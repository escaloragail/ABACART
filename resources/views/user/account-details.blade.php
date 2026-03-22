@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Account Details</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__edit">
                    <div class="my-account__edit-form">
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('user.account.update') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="my-3 text-center">
                                        <div class="mb-3">
                                            @if($user->image)
                                                <img src="{{ asset('uploads/profiles/' . $user->image) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 124px; height: 124px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/images/avatar/user-1.png') }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 124px; height: 124px; object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Change Profile Image</label>
                                            <input type="file" class="form-control" name="image" id="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name }}" required>
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" value="{{ $user->phone_number }}" required>
                                        <label for="phone_number">Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="email" class="form-control" placeholder="Email Address" value="{{ $user->email }}" disabled>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="my-3">
                                        <h5 class="text-uppercase mb-0">Password Change</h5>
                                        <p>Leave blank to leave unchanged.</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" name="password" placeholder="New password">
                                        <label for="password">New password</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                                        <label for="password_confirmation">Confirm new password</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="my-3">
                                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
