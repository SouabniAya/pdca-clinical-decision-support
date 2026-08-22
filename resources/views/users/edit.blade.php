@extends('layouts.app')

@section('title', 'Edit User')

@php($active = 'users')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>Edit User</h1>
            <p>Update this user's information.</p>
        </div>
        <a href="{{ route('users.index') }}" class="patients-page__btn" style="background:#fff;color:#111;border:1px solid #e2e2e2;">
            &larr; Back to Users
        </a>
    </div>

    @if ($errors->any())
        <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;color:#b3261e;border-radius:8px;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="patients-table-wrap" style="padding:24px;">
        <form method="POST" action="{{ route('users.update', $user['id']) }}">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user['first_name']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user['last_name']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user['email']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Role</label>
                    <input type="text" value="{{ $user['role'] }}" disabled style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;background:#f9fafb;color:#6b7280;">
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">New Password (optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="Leave blank to keep current" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
            </div>

            @if ($user['role'] === 'Doctor')
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:18px;margin-bottom:18px;padding-top:18px;border-top:1px solid #f0f0f0;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">License Number</label>
                    <input type="text" name="doctor_license_number" value="{{ old('doctor_license_number', $user['doctor_license_number']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Specialty</label>
                    <input type="text" name="doctor_specialty" value="{{ old('doctor_specialty', $user['doctor_specialty']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Institution</label>
                    <input type="text" name="doctor_institution" value="{{ old('doctor_institution', $user['doctor_institution']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
            </div>
            @endif

            @if ($user['role'] === 'Nurse')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;padding-top:18px;border-top:1px solid #f0f0f0;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">License Number</label>
                    <input type="text" name="nurse_license_number" value="{{ old('nurse_license_number', $user['nurse_license_number']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Department</label>
                    <input type="text" name="nurse_department" value="{{ old('nurse_department', $user['nurse_department']) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
            </div>
            @endif

            <label style="display:flex;align-items:center;gap:8px;margin-bottom:22px;font-size:14px;">
                <input type="checkbox" name="active" value="1" @checked($user['active'])>
                Active account
            </label>

            <button type="submit" class="patients-page__btn">
                Save Changes
            </button>
        </form>
    </div>

</div>
@endsection