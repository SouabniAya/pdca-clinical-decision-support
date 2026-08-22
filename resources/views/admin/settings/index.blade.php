@extends('layouts.app')

@section('title', 'Settings')

@php($active = 'settings')

@section('content')

<div class="settings-page">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="settings-page__head">
        <div>
            <h1>Settings</h1>
            <p>
                Manage your account information and security.
            </p>
        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('success'))
        <div class="settings-alert settings-alert--success">
            {{ session('success') }}
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ========================================================= --}}

    @if ($errors->any())
        <div class="settings-alert settings-alert--error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- SETTINGS NAVIGATION --}}
    {{-- ========================================================= --}}

    <div class="settings-tabs">

        <a
            href="#profile"
            class="settings-tabs__link settings-tabs__link--active"
        >
            Profile
        </a>

        <a
            href="#password"
            class="settings-tabs__link"
        >
            Password
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- PROFILE --}}
    {{-- ========================================================= --}}

    <section id="profile" class="settings-card">

        <div class="settings-card__head">
            <div>
                <h2>Profile Information</h2>

                <p>
                    Update your personal information and contact details.
                </p>
            </div>
        </div>


        <form
            action="{{ route('settings.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="settings-form"
        >

            @csrf
            @method('PUT')


            <div class="settings-form__grid">

                {{-- First Name --}}
                <div class="settings-form__field">

                    <label for="first_name">
                        First Name
                    </label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name', $admin->first_name ?? '') }}"
                        placeholder="First name"
                        required
                    >

                </div>


                {{-- Last Name --}}
                <div class="settings-form__field">

                    <label for="last_name">
                        Last Name
                    </label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name', $admin->last_name ?? '') }}"
                        placeholder="Last name"
                        required
                    >

                </div>


                {{-- Email --}}
                <div class="settings-form__field">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $admin->email ?? '') }}"
                        placeholder="example@email.com"
                        required
                    >

                </div>


                {{-- Phone --}}
                <div class="settings-form__field">

                    <label for="phone">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $admin->phone ?? '') }}"
                        placeholder="+213 555 000 000"
                    >

                </div>


                {{-- Profile Photo --}}
                <div class="settings-form__field">

                    <label for="profile_photo">
                        Profile Photo
                    </label>

                    <input
                        type="file"
                        id="profile_photo"
                        name="profile_photo"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small>
                        JPG, PNG or WEBP. Maximum size: 2 MB.
                    </small>

                </div>


                {{-- Role --}}
                <div class="settings-form__field">

                    <label for="role">
                        Role
                    </label>

                    <input
                        type="text"
                        id="role"
                        value="{{ $admin->role ?? 'Administrator' }}"
                        disabled
                    >

                </div>

            </div>


            <div class="settings-form__actions">

                <button
                    type="submit"
                    class="settings-btn settings-btn--primary"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </section>


    {{-- ========================================================= --}}
    {{-- PASSWORD --}}
    {{-- ========================================================= --}}

    <section id="password" class="settings-card">

        <div class="settings-card__head">

            <div>
                <h2>Password</h2>

                <p>
                    Update your password to keep your account secure.
                </p>
            </div>

        </div>


        <form
            action="{{ route('settings.password.update') }}"
            method="POST"
            class="settings-form"
        >

            @csrf
            @method('PUT')


            <div class="settings-form__grid">

                {{-- Current Password --}}
                <div class="settings-form__field settings-form__field--full">

                    <label for="current_password">
                        Current Password
                    </label>

                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        placeholder="Enter your current password"
                        required
                    >

                </div>


                {{-- New Password --}}
                <div class="settings-form__field">

                    <label for="new_password">
                        New Password
                    </label>

                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        placeholder="Enter new password"
                        required
                    >

                </div>


                {{-- Confirm Password --}}
                <div class="settings-form__field">

                    <label for="new_password_confirmation">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        placeholder="Confirm new password"
                        required
                    >

                </div>

            </div>


            <div class="settings-note">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M12 9v4M12 17v.01"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                </svg>

                <p>
                    Your password must contain at least 8 characters,
                    including an uppercase letter and a number.
                </p>

            </div>


            <div class="settings-form__actions">

                <button
                    type="submit"
                    class="settings-btn settings-btn--primary"
                >
                    Update Password
                </button>

            </div>

        </form>

    </section>


    {{-- ========================================================= --}}
    {{-- DANGER ZONE --}}
    {{-- ========================================================= --}}

    <section class="settings-card settings-card--danger">

        <div class="settings-card__head">

            <div>
                <h2>Danger Zone</h2>

                <p>
                    Irreversible and destructive account actions.
                </p>
            </div>

        </div>


        <div class="settings-danger-row">

            <div>

                <strong>
                    Deactivate Account
                </strong>

                <span>
                    Deactivate your admin account and lose access to the system.
                </span>

            </div>


            <form
                action="{{ route('settings.deactivate') }}"
                method="POST"
                onsubmit="
                    return confirm(
                        'Are you sure you want to deactivate your admin account?'
                    );
                "
            >

                @csrf

                <button
                    type="submit"
                    class="settings-btn settings-btn--danger"
                >
                    Deactivate Account
                </button>

            </form>

        </div>

    </section>

</div>

@endsection