@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Account Settings</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Account Settings</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
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

            <form class="form-new-product form-style-1" action="{{ route('admin.account.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <fieldset>
                    <div class="body-title mb-10">Profile Image</div>
                    <div class="upload-image mb-20">
                        <div class="item" id="imgpreview">
                            @if($user->image)
                                <img src="{{ asset('uploads/profiles/' . $user->image) }}" alt="{{ $user->name }}" class="effect8">
                            @else
                                <img src="{{ asset('assets/images/avatar/user-1.png') }}" alt="{{ $user->name }}" class="effect8">
                            @endif
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter name" name="name" tabindex="0" value="{{ $user->name }}" aria-required="true" required="">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Phone Number <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter phone number" name="phone_number" tabindex="0" value="{{ $user->phone_number }}" aria-required="true" required="">
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Email Address</div>
                        <input class="mb-10" type="email" placeholder="Enter email address" name="email" tabindex="0" value="{{ $user->email }}" aria-required="true" disabled>
                    </fieldset>
                </div>

                <div class="my-3">
                    <h5 class="text-uppercase mb-0">Password Change</h5>
                    <p class="text-tiny">Leave blank to leave unchanged.</p>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">New Password</div>
                        <input class="mb-10" type="password" placeholder="Enter new password" name="password" tabindex="0">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Confirm Password</div>
                        <input class="mb-10" type="password" placeholder="Confirm new password" name="password_confirmation" tabindex="0">
                    </fieldset>
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
