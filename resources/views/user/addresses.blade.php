@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Addresses</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__address">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0">The following addresses will be used on the checkout page.</p>
                        <a href="{{ route('user.address.add') }}" class="btn btn-primary tf-button w208">Add New Address</a>
                    </div>
                    @if(Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    <div class="row">
                        @forelse($addresses as $address)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 d-flex justify-content-between align-items-center">
                                        Shipping Address ({{ $address->address_type }})
                                        <form action="{{ route('user.address.delete', ['id' => $address->Address_ID]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-2 py-1 text-white" title="Delete Address">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <address>
                                        <strong>User Name:</strong> {{ Auth::user()->name }}<br>
                                        <strong>Zone / Street:</strong> {{ $address->Zone_Street_HouseNumber }}<br>
                                        <strong>Barangay:</strong> {{ $address->Barangay }}<br>
                                        <strong>City:</strong> {{ $address->City }}<br>
                                        <strong>Province:</strong> {{ $address->Province }}<br>
                                        <strong>Phone:</strong> {{ Auth::user()->phone_number }}
                                    </address>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <p>You have not set up any shipping addresses yet. You can add one by clicking the button above.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
