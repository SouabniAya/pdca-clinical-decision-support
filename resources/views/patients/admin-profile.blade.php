@extends('layouts.app')

@section('title', 'My Profile')

@php($active = 'profile')

@section('content')

<div class="doctor-profile-page">

    <div class="doctor-profile-page__head">
        <div>
            <a href="{{ route('dashboard') }}" class="doctor-profile-page__back">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Dashboard
            </a>

            <h1>My Profile</h1>
            <p>View your administrator account information.</p>
        </div>

        <a href="{{ route('settings') }}" class="pd-btn pd-btn--primary">Edit in Settings</a>
    </div>

    <div class="doctor-profile-card">

        <div class="doctor-profile-card__identity">
            <div class="doctor-profile-card__avatar">
                <img
                    src="{{ $admin->profile_photo ? asset('storage/' . $admin->profile_photo) : asset('images/default-avatar.jpg') }}"
                    alt="{{ trim($admin->first_name . ' ' . $admin->last_name) }}"
                >
            </div>

            <div class="doctor-profile-card__identity-info">
                <div class="doctor-profile-card__name-row">
                    <h2>{{ trim($admin->first_name . ' ' . $admin->last_name) }}</h2>
                    <span class="doctor-profile-card__status">
                        <span></span>
                        Active
                    </span>
                </div>
                <p class="doctor-profile-card__role">Administrator</p>
            </div>
        </div>

        <div class="doctor-profile-card__divider"></div>

        <section class="doctor-profile-section">
            <div class="doctor-profile-section__head">
                <div class="doctor-profile-section__icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M4 20c0-4 3.6-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h3>Personal Information</h3>
                    <p>Your personal and contact information.</p>
                </div>
            </div>

            <div class="doctor-profile-info-grid">
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Full Name</span>
                    <strong>{{ trim($admin->first_name . ' ' . $admin->last_name) }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Email Address</span>
                    <strong>{{ $admin->email }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Phone Number</span>
                    <strong>{{ $admin->phone ?? 'N/A' }}</strong>
                </div>
            </div>
        </section>

        <section class="doctor-profile-section">
            <div class="doctor-profile-section__head">
                <div class="doctor-profile-section__icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h3>Account Information</h3>
                    <p>Information about your administrator account.</p>
                </div>
            </div>

            <div class="doctor-profile-info-grid">
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Role</span>
                    <strong>Administrator</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Account Status</span>
                    <strong class="doctor-profile-info__active">
                        <span></span>
                        {{ $admin->active ? 'Active' : 'Inactive' }}
                    </strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Member Since</span>
                    <strong>{{ $admin->created_at?->format('F Y') ?? 'N/A' }}</strong>
                </div>
            </div>
        </section>

        <section class="doctor-profile-section">
            <div class="doctor-profile-section__head">
                <div class="doctor-profile-section__icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M13.7 21a2 2 0 0 1-3.4 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h3>Notification Preferences</h3>
                    <p>Manage in Settings which alerts you receive.</p>
                </div>
            </div>

            <div class="doctor-profile-info-grid">
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Email Notifications</span>
                    <strong>{{ $admin->notify_email ? 'Enabled' : 'Disabled' }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">New Patient Alerts</span>
                    <strong>{{ $admin->notify_new_patient ? 'Enabled' : 'Disabled' }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Weekly Summary</span>
                    <strong>{{ $admin->notify_weekly_summary ? 'Enabled' : 'Disabled' }}</strong>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection