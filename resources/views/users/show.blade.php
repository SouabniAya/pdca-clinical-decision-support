@extends('layouts.app')

@section('title', 'User Details')

@php($active = 'users')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>User Details</h1>
            <p>View information for this user account.</p>
        </div>
        <a href="{{ route('users.index') }}" class="patients-page__btn" style="background:#fff;color:#111;border:1px solid #e2e2e2;">
            &larr; Back to Users
        </a>
    </div>

    @if (session('success'))
        <div style="margin-bottom:16px;padding:12px 16px;background:#e6f7ec;color:#1a7f3c;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="patients-table-wrap" style="padding:24px;">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
            <span style="width:56px;height:56px;border-radius:50%;background:var(--color-cerulean, #2563eb);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:18px;">
                {{ strtoupper(substr($user['name'], 0, 1)) }}
            </span>
            <div>
                <h2 style="margin:0 0 4px;font-size:20px;">{{ $user['name'] }}</h2>
                <span style="color:#6b7280;font-size:14px;">ID: {{ $user['id'] }}</span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px 32px;">
            <div>
                <span style="display:block;font-size:12.5px;color:#6b7280;margin-bottom:4px;">Email</span>
                <strong style="font-size:14.5px;">{{ $user['email'] }}</strong>
            </div>
            <div>
                <span style="display:block;font-size:12.5px;color:#6b7280;margin-bottom:4px;">Role</span>
                <strong style="font-size:14.5px;">{{ $user['role'] }}</strong>
            </div>
            <div>
                <span style="display:block;font-size:12.5px;color:#6b7280;margin-bottom:4px;">Status</span>
                <span class="patients-table__status">{{ $user['status'] }}</span>
            </div>

            @foreach (($user['extra'] ?? []) as $label => $value)
                @if (!empty($value))
                <div>
                    <span style="display:block;font-size:12.5px;color:#6b7280;margin-bottom:4px;">{{ $label }}</span>
                    <strong style="font-size:14.5px;">{{ $value }}</strong>
                </div>
                @endif
            @endforeach
        </div>

        <div style="margin-top:28px;display:flex;gap:10px;">
            <a href="{{ route('users.edit', $user['id']) }}" class="patients-page__btn">
                Edit User
            </a>
            <form method="POST" action="{{ route('users.destroy', $user['id']) }}" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:11px 18px;border:1px solid #f0c9c9;background:#fff;color:#c0392b;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;">
                    Delete User
                </button>
            </form>
        </div>
    </div>

</div>
@endsection