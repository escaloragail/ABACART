@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Add New Address</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__address-edit">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form name="address-new-form" class="needs-validation" novalidate="" action="{{ route('user.address.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="Zone_Street_HouseNumber" placeholder="Zone / Street / House No" value="{{ old('Zone_Street_HouseNumber') }}" required>
                                    <label for="Zone_Street_HouseNumber">Zone / Street / House No *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="Barangay" placeholder="Barangay" value="{{ old('Barangay') }}" required>
                                    <label for="Barangay">Barangay *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="City" placeholder="City" value="{{ old('City') }}" required>
                                    <label for="City">City *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="Province" placeholder="Province" value="{{ old('Province') }}" required>
                                    <label for="Province">Province *</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <select class="form-select" name="address_type" required>
                                        <option value="Home" {{ old('address_type') == 'Home' ? 'selected' : '' }}>Home</option>
                                        <option value="Office" {{ old('address_type') == 'Office' ? 'selected' : '' }}>Office</option>
                                        <option value="Other" {{ old('address_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="address_type">Address Type *</label>
                                </div>
                            </div>
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary tf-button w208">Save Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
