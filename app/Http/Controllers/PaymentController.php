<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'reference_number' => ['required', 'string', 'max:100', 'unique:payments,reference_number'],
            'amount' => ['required', 'numeric', 'min:1'],
            'proof_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $uploadPath = public_path('uploads/payments');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $image = $request->file('proof_image');
        $imageName = now()->timestamp . '-' . Str::random(10) . '.' . $image->extension();
        $image->move($uploadPath, $imageName);

        $validated['proof_image'] = 'uploads/payments/' . $imageName;

        $payment = Payment::create($validated);

        return view('payments.success', compact('payment'));
    }
}
