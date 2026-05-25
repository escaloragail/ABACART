@extends('layouts.app')

@push('styles')
<style>
    .payment-success-page {
        background: #f4faf6;
        min-height: calc(100vh - 84px);
        padding: 110px 18px 70px;
        font-family: "Jost", sans-serif;
    }

    .success-panel {
        max-width: 920px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #dceee2;
        border-radius: 20px;
        box-shadow: 0 18px 45px rgba(18, 92, 48, .09);
        overflow: hidden;
    }

    .success-header {
        background: linear-gradient(135deg, #188444, #29a85d);
        color: #fff;
        padding: 28px;
    }

    .success-badge {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: rgba(255, 255, 255, .18);
        display: grid;
        place-items: center;
        font-size: 24px;
        margin-bottom: 14px;
    }

    .success-header h1 {
        font-size: 30px;
        font-weight: 800;
        margin: 0;
    }

    .success-header p {
        margin: 7px 0 0;
        opacity: .9;
    }

    .success-body {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 24px;
        padding: 28px;
    }

    .detail-list {
        display: grid;
        gap: 12px;
    }

    .detail-row {
        border: 1px solid #e2efe6;
        border-radius: 14px;
        padding: 12px 14px;
        background: #fbfefc;
    }

    .detail-label {
        color: #687970;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 3px;
    }

    .detail-value {
        color: #14241b;
        font-size: 15px;
        font-weight: 700;
        word-break: break-word;
    }

    .proof-card {
        border: 1px solid #e2efe6;
        border-radius: 16px;
        padding: 14px;
        background: #fbfefc;
    }

    .proof-card img {
        width: 100%;
        border-radius: 12px;
        display: block;
        object-fit: cover;
    }

    .success-actions {
        padding: 0 28px 28px;
    }

    .success-actions a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 10px 18px;
        border-radius: 12px;
        background: #16803d;
        color: #fff;
        font-weight: 800;
        text-decoration: none;
    }

    @media (max-width: 780px) {
        .success-body {
            grid-template-columns: 1fr;
        }

        .payment-success-page {
            padding-top: 92px;
        }
    }
</style>
@endpush

@section('content')
<main class="payment-success-page">
    <div class="success-panel">
        <div class="success-header">
            <div class="success-badge">
                <i class="fa fa-check"></i>
            </div>
            <h1>Payment Submitted</h1>
            <p>Your GreenPay manual payment record has been saved successfully.</p>
        </div>

        <div class="success-body">
            <div class="detail-list">
                <div class="detail-row">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">{{ $payment->fullname }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Mobile Number</div>
                    <div class="detail-value">{{ $payment->mobile_number }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email Address</div>
                    <div class="detail-value">{{ $payment->email }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Reference Number</div>
                    <div class="detail-value">{{ $payment->reference_number }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Amount</div>
                    <div class="detail-value">PHP {{ number_format($payment->amount, 2) }}</div>
                </div>
                @if($payment->notes)
                    <div class="detail-row">
                        <div class="detail-label">Notes</div>
                        <div class="detail-value">{{ $payment->notes }}</div>
                    </div>
                @endif
            </div>

            <aside class="proof-card">
                <div class="detail-label mb-2">Uploaded Proof</div>
                <img src="{{ asset($payment->proof_image) }}" alt="Uploaded proof of payment">
            </aside>
        </div>

        <div class="success-actions">
            <a href="{{ route('payment.create') }}">
                <i class="fa fa-plus-circle me-1"></i> Submit Another Payment
            </a>
        </div>
    </div>
</main>
@endsection
