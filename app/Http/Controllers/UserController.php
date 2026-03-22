<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Address;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function orders()
    {
        $user_id = Auth::user()->User_ID;
        $orders = Order::where('User_ID', $user_id)->orderBy('created_at', 'DESC')->paginate(10);
        $ordered_orders = Order::where('User_ID', $user_id)->where('order_status', 'ordered')->orderBy('created_at', 'DESC')->get();
        $delivered_orders = Order::where('User_ID', $user_id)->where('order_status', 'delivered')->orderBy('created_at', 'DESC')->get();
        $canceled_orders = Order::where('User_ID', $user_id)->where('order_status', 'canceled')->orderBy('created_at', 'DESC')->get();

        return view('user.orders', compact('orders', 'ordered_orders', 'delivered_orders', 'canceled_orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('User_ID', Auth::user()->User_ID)->where('Order_ID', $order_id)->first();
        if(!$order) {
            return redirect()->route('user.orders');
        }

        $orderItems = OrderItem::where('Order_ID', $order_id)->orderBy('Order_Item_ID')->paginate(12);
        $transaction = Transaction::where('Order_ID', $order_id)->first();
        $address = Address::where('User_ID', $order->User_ID)->where('Address_ID', $order->Address_ID ?? 0)->first();
        if(!$address) {
             $address = Address::where('User_ID', Auth::user()->User_ID)->orderBy('Address_ID', 'DESC')->first();
        }

        return view('user.order-details', compact('order', 'orderItems', 'transaction', 'address'));
    }

    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        if($order && $order->User_ID == Auth::user()->User_ID) {
            $order->order_status = 'canceled';
            $order->date_cancelled = Carbon::now();
            $order->save();

            $transaction = Transaction::where('Order_ID', $request->order_id)->first();
            if($transaction) {
                $transaction->status = 'declined';
                $transaction->save();
            }
            return back()->with('success', 'Order has been canceled successfully!');
        }
        return back()->with('error', 'Operation failed.');
    }

    public function account_details()
    {
        $user = Auth::user();
        return view('user.account-details', compact('user'));
    }

    public function account_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user = \App\Models\User::find(Auth::user()->User_ID);
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;

        if ($request->hasFile('image')) {
            if ($user->image && \Illuminate\Support\Facades\File::exists(public_path('uploads/profiles/' . $user->image))) {
                \Illuminate\Support\Facades\File::delete(public_path('uploads/profiles/' . $user->image));
            }
            $image = $request->file('image');
            $imageName = \Carbon\Carbon::now()->timestamp . '.' . $image->extension();
            $this->GenerateProfileImage($image, $imageName);
            $user->image = $imageName;
        }

        if($request->password) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Account details updated successfully!');
    }

    public function addresses()
    {
        $addresses = Address::where('User_ID', Auth::user()->User_ID)->orderBy('Address_ID', 'DESC')->get();
        return view('user.addresses', compact('addresses'));
    }

    public function address_add()
    {
        return view('user.address-add');
    }

    public function address_store(Request $request)
    {
        $request->validate([
            'Zone_Street_HouseNumber' => 'required',
            'Barangay' => 'required',
            'City' => 'required',
            'Province' => 'required',
            'address_type' => 'required'
        ]);

        $address = new Address();
        $address->User_ID = Auth::user()->User_ID;
        $address->Zone_Street_HouseNumber = $request->Zone_Street_HouseNumber;
        $address->Barangay = $request->Barangay;
        $address->City = $request->City;
        $address->Province = $request->Province;
        $address->address_type = $request->address_type;
        $address->save();

        return redirect()->route('user.addresses')->with('success', 'Address added successfully!');
    }

    public function GenerateProfileImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/profiles');

        if (!\Illuminate\Support\Facades\File::exists($destinationPath)) {
            \Illuminate\Support\Facades\File::makeDirectory($destinationPath, 0755, true);
        }

        $img = \Intervention\Image\Laravel\Facades\Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
}
