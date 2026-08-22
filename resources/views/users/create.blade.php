@extends('layouts.app')

@section('title', 'New User')

@php($active = 'users')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>New User</h1>
            <p>Create a new account — doctor, nurse, visitor or administrator.</p>
        </div>
        <a href="{{ route('users.index') }}" class="patients-page__btn patients-page__btn--ghost">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Users
        </a>
    </div>

    <form class="clinical-form" method="POST" action="{{ route('users.store') }}">
        @csrf

        @if ($errors->any())
            <div class="clinical-form__error">{{ $errors->first() }}</div>
        @endif

        {{-- Role --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s-7-4.4-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6c-2.5 4.6-9.5 9-9.5 9Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                <h2>Role</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="role">Account type</label>
                    <select id="role" name="role" required onchange="toggleRoleFields(this.value)">
                        <option value="">Select...</option>
                        <option value="Doctor" @selected(old('role') == 'Doctor')>Doctor</option>
                        <option value="Nurse" @selected(old('role') == 'Nurse')>Nurse</option>
                        <option value="Visitor" @selected(old('role') == 'Visitor')>Visitor</option>
                        <option value="Administrator" @selected(old('role') == 'Administrator')>Administrator</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Personal info --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <h2>Personal Information</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="first_name">First name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                </div>

                <div class="clinical-form__field">
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                </div>

                <div class="clinical-form__field">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="clinical-form__field clinical-form__field--checkbox">
                    <label class="clinical-form__checkbox">
                        <input type="checkbox" name="active" value="1" @checked(old('active', true))>
                        Active account
                    </label>
                </div>
            </div>
        </div>

        {{-- Password --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 10V7a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="1.6"/></svg>
                <h2>Password</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required minlength="8">
                </div>

                <div class="clinical-form__field">
                    <label for="password_confirmation">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
                </div>
            </div>
        </div>

        {{-- Doctor-specific --}}
        <div class="clinical-form__section" id="fields-doctor" style="display:none;">
            <div class="clinical-form__section-head">
                <h2>Doctor Details</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="doctor_license_number">License number</label>
                    <input type="text" id="doctor_license_number" name="doctor_license_number" value="{{ old('doctor_license_number') }}">
                </div>
                <div class="clinical-form__field">
                    <label for="doctor_specialty">Specialty</label>
                    <input type="text" id="doctor_specialty" name="doctor_specialty" value="{{ old('doctor_specialty') }}">
                </div>
                <div class="clinical-form__field">
                    <label for="doctor_institution">Institution</label>
                    <input type="text" id="doctor_institution" name="doctor_institution" value="{{ old('doctor_institution') }}">
                </div>
            </div>
        </div>

        {{-- Nurse-specific --}}
        <div class="clinical-form__section" id="fields-nurse" style="display:none;">
            <div class="clinical-form__section-head">
                <h2>Nurse Details</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="nurse_license_number">License number</label>
                    <input type="text" id="nurse_license_number" name="nurse_license_number" value="{{ old('nurse_license_number') }}">
                </div>
                <div class="clinical-form__field">
                    <label for="nurse_department">Department</label>
                    <input type="text" id="nurse_department" name="nurse_department" value="{{ old('nurse_department') }}">
                </div>
            </div>
        </div>

        <div class="clinical-form__actions">
            <a href="{{ route('users.index') }}" class="clinical-form__cancel">Cancel</a>
            <button type="submit" class="clinical-form__submit">Create User</button>
        </div>
    </form>

</div>

<script>
    function toggleRoleFields(role) {
        document.getElementById('fields-doctor').style.display = (role === 'Doctor') ? 'block' : 'none';
        document.getElementById('fields-nurse').style.display = (role === 'Nurse') ? 'block' : 'none';
    }
    // Re-apply on page load in case of validation error (old('role') pre-selected)
    document.addEventListener('DOMContentLoaded', function () {
        toggleRoleFields(document.getElementById('role').value);
    });
</script>
@endsection