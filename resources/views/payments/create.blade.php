@extends('layouts.app')

@push('styles')
<style>
    .payment-page {
        background: #f4faf6;
        min-height: calc(100vh - 84px);
        padding: 110px 0 70px;
        font-family: "Jost", sans-serif;
    }

    .payment-shell {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 18px;
    }

    .payment-heading {
        margin-bottom: 28px;
    }

    .payment-kicker {
        color: #16803d;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .payment-title {
        color: #102017;
        font-size: 34px;
        font-weight: 800;
        margin: 0;
    }

    .payment-subtitle {
        color: #62706a;
        font-size: 15px;
        margin: 8px 0 0;
        max-width: 620px;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: minmax(280px, 380px) 1fr;
        gap: 22px;
        align-items: start;
    }

    .wallet-panel,
    .payment-form-panel {
        background: #fff;
        border: 1px solid #dceee2;
        border-radius: 18px;
        box-shadow: 0 18px 45px rgba(18, 92, 48, .09);
    }

    .wallet-panel {
        padding: 22px;
    }

    .payment-method {
        border: 1px solid #cce9d5;
        border-radius: 16px;
        background: linear-gradient(135deg, #188444, #29a85d);
        color: #fff;
        padding: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .payment-method-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(255, 255, 255, .18);
        display: grid;
        place-items: center;
        font-size: 19px;
    }

    .payment-method-name {
        font-size: 20px;
        font-weight: 800;
        margin: 0;
    }

    .payment-method-caption {
        font-size: 12px;
        opacity: .84;
        margin: 2px 0 0;
    }

    .qr-box {
        text-align: center;
        padding: 16px;
        background: #f7fcf8;
        border: 1px dashed #b8e4c4;
        border-radius: 16px;
    }

    .qr-box img {
        width: 100%;
        max-width: 240px;
        border-radius: 16px;
    }

    .qr-note {
        color: #52635a;
        font-size: 13px;
        margin: 14px 0 0;
    }

    .payment-form-panel {
        padding: 28px;
    }

    .payment-form-panel label {
        color: #24342c;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .payment-form-panel .form-control {
        border: 1px solid #d8e7dd;
        border-radius: 12px;
        color: #15231b;
        font-size: 14px;
        min-height: 48px;
        padding: 11px 14px;
    }

    .payment-form-panel .form-control:focus {
        border-color: #27a857;
        box-shadow: 0 0 0 .2rem rgba(39, 168, 87, .13);
    }

    .submit-payment-btn {
        width: 100%;
        border: 0;
        border-radius: 14px;
        background: #16803d;
        color: #fff;
        font-weight: 800;
        padding: 14px 18px;
        transition: .2s ease;
    }

    .submit-payment-btn:hover {
        background: #116934;
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(22, 128, 61, .22);
    }

    .form-help {
        color: #6a7b72;
        font-size: 12px;
        margin-top: 7px;
    }

    @media (max-width: 900px) {
        .payment-grid {
            grid-template-columns: 1fr;
        }

        .payment-page {
            padding-top: 92px;
        }
    }
</style>
@endpush

@section('content')
<main class="payment-page">
    <div class="payment-shell">
        <div class="payment-heading">
            <div class="payment-kicker">Manual Online Payment</div>
            <h1 class="payment-title">Pay with GreenPay</h1>
            <p class="payment-subtitle">Upload your payment proof after sending your payment. This is a manual submission only and does not connect to any real wallet API.</p>
        </div>

        <div class="payment-grid">
            <aside class="wallet-panel">
                <div class="payment-method">
                    <div>
                        <p class="payment-method-name">GreenPay</p>
                        <p class="payment-method-caption">School payment wallet</p>
                    </div>
                    <div class="payment-method-icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                </div>

                <div class="qr-box">
                    <img src="{{ asset('images/payments/greenpay-qr-placeholder.svg') }}" alt="GreenPay QR code placeholder">
                    <p class="qr-note">Scan this placeholder QR in your school demo flow, then enter the reference number below.</p>
                </div>
            </aside>

            <section class="payment-form-panel">
                <form method="POST" action="{{ route('payment.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fullname">Full Name</label>
                            <input id="fullname" type="text" name="fullname" value="{{ old('fullname') }}" class="form-control @error('fullname') is-invalid @enderror" required>
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="mobile_number">Mobile Number</label>
                            <input id="mobile_number" type="text" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control @error('mobile_number') is-invalid @enderror" required>
                            @error('mobile_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="reference_number">Reference Number</label>
                            <input id="reference_number" type="text" name="reference_number" value="{{ old('reference_number') }}" class="form-control @error('reference_number') is-invalid @enderror" required>
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="amount">Amount</label>
                            <input id="amount" type="number" step="0.01" min="1" name="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="proof_image">Upload Proof of Payment</label>
                            <input id="proof_image" type="file" name="proof_image" accept="image/png,image/jpeg,image/webp" class="form-control @error('proof_image') is-invalid @enderror" required>
                            <div class="form-help">Accepted files: JPG, PNG, WEBP. Max size: 2MB.</div>
                            @error('proof_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label for="notes">Notes (optional)</label>
                            <textarea id="notes" name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="submit-payment-btn">
                        <i class="fa fa-check-circle me-1"></i> Submit Payment
                    </button>
                </form>
            </section>
        </div>
    </div>
</main>
@endsection
