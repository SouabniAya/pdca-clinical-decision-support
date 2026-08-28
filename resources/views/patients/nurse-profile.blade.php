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
            <p>View your personal and professional information.</p>
        </div>
    </div>

    <div class="doctor-profile-card">

        <div class="doctor-profile-card__identity">
            <div class="doctor-profile-card__avatar">
                <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ auth()->user()->name }}">
            </div>

            <div class="doctor-profile-card__identity-info">
                <div class="doctor-profile-card__name-row">
                    <h2>{{ auth()->user()->name }}</h2>
                    <span class="doctor-profile-card__status">
                        <span></span>
                        Active
                    </span>
                </div>
                <p class="doctor-profile-card__role">Nurse</p>
                <p class="doctor-profile-card__speciality">{{ $nurse['department'] }}</p>
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
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Email Address</span>
                    <strong>{{ auth()->user()->email }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Phone Number</span>
                    <strong>{{ auth()->user()->phone ?? 'N/A' }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Location</span>
                    <strong>{{ auth()->user()->location ?? 'N/A' }}</strong>
                </div>
            </div>
        </section>

        <section class="doctor-profile-section">
            <div class="doctor-profile-section__head">
                <div class="doctor-profile-section__icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M4 20h16" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        <path d="M6 20V9l6-4 6 4v11" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M10 20v-5h4v5" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <h3>Professional Information</h3>
                    <p>Your professional information.</p>
                </div>
            </div>

            <div class="doctor-profile-info-grid">
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Role</span>
                    <strong>Nurse</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Department</span>
                    <strong>{{ $nurse['department'] }}</strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">License Number</span>
                    <strong>{{ $nurse['license_number'] }}</strong>
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
                    <p>Information about your account.</p>
                </div>
            </div>

            <div class="doctor-profile-info-grid">
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Account Status</span>
                    <strong class="doctor-profile-info__active">
                        <span></span>
                        Active
                    </strong>
                </div>
                <div class="doctor-profile-info">
                    <span class="doctor-profile-info__label">Member Since</span>
                    <strong>{{ auth()->user()?->created_at?->format('F Y') ?? 'N/A' }}</strong>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection