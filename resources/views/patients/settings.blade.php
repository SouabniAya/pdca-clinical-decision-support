@extends('layouts.app')

@section('title', 'Settings')

@php($active = 'settings')

@section('content')
<div class="settings-page">

    <div class="settings-page__head">
        <div>
            <h1>Settings</h1>
            <p>Manage your account information, security, and preferences.</p>
        </div>
    </div>

    <div class="settings-tabs">
        <a href="#profile" class="settings-tabs__link settings-tabs__link--active">Profile</a>
        <a href="#password" class="settings-tabs__link">Password</a>
        <a href="#preferences" class="settings-tabs__link">Preferences</a>
    </div>

    {{-- ================= Profile information ================= --}}
    <section id="profile" class="settings-card">
        <div class="settings-card__head">
            <div>
                <h2>Profile Information</h2>
                <p>Update your name, email address, and contact details.</p>
            </div>
        </div>

        <form action="{{ route('settings.profile.update') }}" method="POST" class="settings-form">
            @csrf
            @method('PUT')

            <div class="settings-form__avatar">
                <div class="settings-form__avatar-circle">SM</div>
                <div>
                    <button type="button" class="settings-btn settings-btn--secondary">Change Photo</button>
                    <span class="settings-form__hint">JPG or PNG, max 2MB</span>
                </div>
            </div>

            <div class="settings-form__grid">
                <div class="settings-form__field">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->name ?? '') }}" placeholder="Dr. Sara Meziane">
                </div>

                <div class="settings-form__field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="sara.meziane@clinic.com">
                </div>

                <div class="settings-form__field">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="+213 555 000 000">
                </div>

                <div class="settings-form__field">
                    <label for="role">Role</label>
                    <input type="text" id="role" value="{{ $user->role ?? 'Clinician' }}" disabled>
                </div>
            </div>

            <div class="settings-form__actions">
                <button type="submit" class="settings-btn settings-btn--primary">Save Changes</button>
            </div>
        </form>
    </section>

    {{-- ================= Password ================= --}}
    <section id="password" class="settings-card">
        <div class="settings-card__head">
            <div>
                <h2>Password</h2>
                <p>Choose a strong password you don't use elsewhere.</p>
            </div>
        </div>

        <form action="{{ route('settings.password.update') }}" method="POST" class="settings-form">
            @csrf
            @method('PUT')

            <div class="settings-form__grid">
                <div class="settings-form__field settings-form__field--full">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" placeholder="••••••••">
                </div>

                <div class="settings-form__field">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" placeholder="••••••••">
                </div>

                <div class="settings-form__field">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="••••••••">
                </div>
            </div>

            <div class="settings-note">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 9v4M12 17v.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                <p>Use at least 8 characters, including a number and an uppercase letter.</p>
            </div>

            <div class="settings-form__actions">
                <button type="submit" class="settings-btn settings-btn--primary">Update Password</button>
            </div>
        </form>
    </section>

    {{-- ================= Preferences ================= --}}
    <section id="preferences" class="settings-card">
        <div class="settings-card__head">
            <div>
                <h2>Preferences</h2>
                <p>Control how you receive notifications from the system.</p>
            </div>
        </div>

        <form action="{{ route('settings.preferences.update') }}" method="POST" class="settings-form">
            @csrf
            @method('PUT')

            <div class="settings-toggle-list">

                <div class="settings-toggle">
                    <div>
                        <strong>Email Notifications</strong>
                        <span>Receive an email when a new recommendation is generated.</span>
                    </div>
                    <label class="settings-switch">
                        <input type="checkbox" name="notify_email" checked>
                        <span class="settings-switch__slider"></span>
                    </label>
                </div>

                <div class="settings-toggle">
                    <div>
                        <strong>New Patient Alerts</strong>
                        <span>Get notified whenever a new patient is registered.</span>
                    </div>
                    <label class="settings-switch">
                        <input type="checkbox" name="notify_new_patient" checked>
                        <span class="settings-switch__slider"></span>
                    </label>
                </div>

                <div class="settings-toggle">
                    <div>
                        <strong>Weekly Summary Report</strong>
                        <span>Receive a weekly digest of patient activity and stats.</span>
                    </div>
                    <label class="settings-switch">
                        <input type="checkbox" name="notify_weekly_summary">
                        <span class="settings-switch__slider"></span>
                    </label>
                </div>

                <div class="settings-toggle">
                    <div>
                        <strong>Dark Mode</strong>
                        <span>Switch the interface to a darker color theme.</span>
                    </div>
                    <label class="settings-switch">
                        <input type="checkbox" name="dark_mode">
                        <span class="settings-switch__slider"></span>
                    </label>
                </div>

            </div>

            <div class="settings-form__actions">
                <button type="submit" class="settings-btn settings-btn--primary">Save Preferences</button>
            </div>
        </form>
    </section>

    {{-- ================= Danger zone ================= --}}
    <section class="settings-card settings-card--danger">
        <div class="settings-card__head">
            <div>
                <h2>Danger Zone</h2>
                <p>Irreversible and destructive actions.</p>
            </div>
        </div>

        <div class="settings-danger-row">
            <div>
                <strong>Deactivate Account</strong>
                <span>You will lose access to the system until an admin reactivates your account.</span>
            </div>
            <button type="button" class="settings-btn settings-btn--danger">Deactivate Account</button>
        </div>
    </section>

</div>
@endsection
