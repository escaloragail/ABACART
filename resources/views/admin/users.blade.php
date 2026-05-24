@extends('layouts.admin')
@section('content')
<style>
    /* ── Users Page Styles (matches existing B&W aesthetic) ── */
    .sales-filter-bar {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        margin-bottom: 24px;
    }
    .sales-filter-bar form {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
    }
    .sales-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .sales-filter-group label {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-filter-apply {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 11px 24px;
        background: #111;
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-filter-apply:hover {
        background: #2d3748;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-filter-reset {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 11px 24px;
        background: transparent;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-filter-reset:hover {
        background: #f1f5f9;
        color: #475569;
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        {{-- Header --}}
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>User Management</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">User</div></li>
            </ul>
        </div>

        {{-- Filter Bar --}}
        <div class="sales-filter-bar">
            <form method="GET" action="{{ route('admin.users') }}">
                <div class="sales-filter-group" style="flex: 1; min-width: 250px;">
                    <label>Search User</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, or phone..." style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #0f172a; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; outline: none; transition: border-color 0.2s ease; width: 100%;">
                </div>
                <div class="sales-filter-group">
                    <label>Role</label>
                    <select name="role" style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #0f172a; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; outline: none; min-width: 140px; cursor: pointer;">
                        <option value="all" {{ $role == 'all' || !$role ? 'selected' : '' }}>All Roles</option>
                        <option value="ADM" {{ $role == 'ADM' ? 'selected' : '' }}>Admin</option>
                        <option value="USR" {{ $role == 'USR' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="sales-filter-group">
                    <label>Status</label>
                    <select name="status" style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #0f172a; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; outline: none; min-width: 140px; cursor: pointer;">
                        <option value="all" {{ $status == 'all' || $status === null ? 'selected' : '' }}>All Statuses</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter-apply">Filter</button>
                <a href="{{ route('admin.users') }}" class="btn-filter-reset">Reset</a>
            </form>
        </div>

        {{-- Users Table --}}
        <div class="wg-box">
            @if (Session::has('success'))
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif
            @if (Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif

            <div class="wg-table table-all-user">
                <div class="table-responsive modern-table-wrap">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td class="td-id">#{{ $user->User_ID }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div class="image" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; background: #f1f5f9;">
                                            @if($user->image)
                                                <img src="{{ asset('uploads/profiles') }}/{{ $user->image }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('images/logo/logo.png') }}" alt="Default" style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); opacity: 0.6;">
                                            @endif
                                        </div>
                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number ?? 'N/A' }}</td>
                                <td>
                                    <form action="{{ route('admin.users.update_role', ['id' => $user->User_ID]) }}" method="POST" class="d-inline role-change-form">
                                        @csrf
                                        @method('PUT')
                                        <select name="utype" onchange="confirmRoleChange(this)" style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; color: #0f172a; padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; outline: none; cursor: pointer;" {{ $user->User_ID === Auth::user()->User_ID ? 'disabled' : '' }}>
                                            <option value="ADM" {{ $user->utype == 'ADM' ? 'selected' : '' }}>Admin</option>
                                            <option value="USR" {{ $user->utype == 'USR' ? 'selected' : '' }}>User</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="modern-badge bg-success-soft">Active</span>
                                    @else
                                        <span class="modern-badge bg-danger-soft">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    @if($user->User_ID !== Auth::user()->User_ID)
                                        <form action="{{ route('admin.users.toggle_status', ['id' => $user->User_ID]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            @if($user->is_active)
                                                <button type="button" class="btn-action-pill btn-delete deactivate-user">
                                                    Deactivate
                                                </button>
                                            @else
                                                <button type="button" class="btn-action-pill reactivate-user">
                                                    Reactivate
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <span style="font-size: 12px; color: #94a3b8; font-weight: 600; font-style: italic;">Self (Active)</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align:center; padding:40px 20px; color:#94a3b8; font-size:14px;">
                                    No users found matching the criteria.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    /* Custom SweetAlert Black & White Aesthetic */
    .swal-modal {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 20px;
    }
    .swal-title {
        font-family: 'Inter', sans-serif;
        color: #111;
        font-weight: 800;
        font-size: 20px;
        margin-bottom: 10px;
    }
    .swal-text {
        font-family: 'Inter', sans-serif;
        color: #64748b;
        text-align: center;
        font-size: 14px;
    }
    .swal-button {
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 30px;
        font-size: 11px;
        transition: all 0.2s ease;
    }
    .swal-button--cancel {
        background-color: #fff !important;
        color: #111 !important;
        border: 1px solid #111 !important;
        box-shadow: none !important;
    }
    .swal-button--cancel:hover {
        background-color: #f1f5f9 !important;
    }
    .swal-button--confirm {
        background-color: #111 !important;
        color: #fff !important;
        border: 1px solid #111 !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
    }
    .swal-button--confirm:hover {
        background-color: #2d3748 !important;
    }
    .swal-icon {
        display: none !important;
    }
</style>
<script>
    function confirmRoleChange(selectElement) {
        var originalValue = selectElement.getAttribute('data-original') || selectElement.defaultValue;
        var newValue = selectElement.value;
        var form = selectElement.closest('form');
        
        swal({
            title: "Change User Role?",
            text: "Are you sure you want to change this user's role?",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "swal-button--cancel",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, Change Role",
                    value: true,
                    visible: true,
                    className: "swal-button--confirm",
                    closeModal: true
                }
            }
        }).then(function (result) {
            if (result) {
                form.submit();
            } else {
                // Reset select value to previous state if cancelled
                selectElement.value = originalValue;
            }
        });
    }

    $(function(){
        // Store original values of select elements
        $('.role-change-form select').each(function() {
            $(this).attr('data-original', $(this).value || $(this).find('option[selected]').val());
        });

        $('.deactivate-user').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Deactivate User?",
                text: "The user will be logged out and blocked from logging in.",
                buttons: {
                    cancel: {
                        text: "No, Keep Active",
                        value: null,
                        visible: true,
                        className: "swal-button--cancel",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, Deactivate",
                        value: true,
                        visible: true,
                        className: "swal-button--confirm",
                        closeModal: true
                    }
                }
            }).then(function (result) {
                if (result) {
                    form.submit();
                }
            });
        });

        $('.reactivate-user').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Reactivate User?",
                text: "The user will be able to log in and use their account.",
                buttons: {
                    cancel: {
                        text: "No, Cancel",
                        value: null,
                        visible: true,
                        className: "swal-button--cancel",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, Reactivate",
                        value: true,
                        visible: true,
                        className: "swal-button--confirm",
                        closeModal: true
                    }
                }
            }).then(function (result) {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
