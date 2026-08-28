<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete your registration — PDCA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="login-page">

        <div class="login-panel">
            <form class="login-form" method="POST" action="{{ route('register.store') }}">
                @csrf

                @if ($errors->any())
                    <div class="login-form__error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <p style="margin-bottom: 16px;">
                    Signed in with Google as <strong>{{ $google['email'] }}</strong>.
                    Please complete your profile to finish creating your account.
                </p>

                <div class="login-field">
                    <input
                        type="text"
                        name="first_name"
                        value="{{ old('first_name', $google['first_name']) }}"
                        placeholder="First name"
                        required
                        autofocus
                    >
                </div>

                <div class="login-field">
                    <input
                        type="text"
                        name="last_name"
                        value="{{ old('last_name', $google['last_name']) }}"
                        placeholder="Last name"
                        required
                    >
                </div>

                <div class="login-field">
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Phone number (optional)"
                    >
                </div>

                <div class="login-field">
                    <input
                        type="text"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Location (optional)"
                    >
                </div>

                {{-- Role selection --}}
                <div class="login-field" style="flex-direction: column; align-items: flex-start; gap: 8px;">
                    <label style="font-weight: 600; margin-bottom: 4px;">I am a:</label>

                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="radio" name="role" value="doctor" class="role-radio"
                               {{ old('role', 'doctor') === 'doctor' ? 'checked' : '' }}>
                        Doctor
                    </label>

                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="radio" name="role" value="nurse" class="role-radio"
                               {{ old('role') === 'nurse' ? 'checked' : '' }}>
                        Nurse
                    </label>

                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="radio" name="role" value="visitor" class="role-radio"
                               {{ old('role') === 'visitor' ? 'checked' : '' }}>
                        Visitor
                    </label>
                </div>

                {{-- Doctor-specific fields --}}
                <div id="fields-doctor" class="role-fields">
                    <div class="login-field">
                        <input type="text" name="specialty" value="{{ old('specialty') }}" placeholder="Specialty">
                    </div>
                    <div class="login-field">
                        <input type="text" name="institution" value="{{ old('institution') }}" placeholder="Hospital / Institution">
                    </div>
                    <div class="login-field">
                        <input type="text" name="license_number" value="{{ old('license_number') }}" placeholder="License number" id="doctor-license">
                    </div>
                </div>

                {{-- Nurse-specific fields --}}
                <div id="fields-nurse" class="role-fields" style="display:none;">
                    <div class="login-field">
                        <input type="text" name="department" value="{{ old('department') }}" placeholder="Department">
                    </div>
                    <div class="login-field">
                        <input type="text" name="license_number" value="{{ old('license_number') }}" placeholder="License number" id="nurse-license">
                    </div>
                </div>

                <div class="login-field">
                    <input
                        type="password"
                        name="password"
                        placeholder="Choose a password"
                        required
                    >
                </div>

                <div class="login-field">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        required
                    >
                </div>

                <button type="submit" class="login-form__submit">Complete registration</button>
            </form>
        </div>

        <div class="login-visual"></div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radios = document.querySelectorAll('.role-radio');
            const doctorFields = document.getElementById('fields-doctor');
            const nurseFields = document.getElementById('fields-nurse');

            function updateFields() {
                const selected = document.querySelector('.role-radio:checked')?.value;

                doctorFields.style.display = selected === 'doctor' ? 'block' : 'none';
                nurseFields.style.display = selected === 'nurse' ? 'block' : 'none';

                // Only require license_number for the visible role, so hidden
                // fields don't block submission with "required".
                document.getElementById('doctor-license').required = (selected === 'doctor');
                document.getElementById('nurse-license').required = (selected === 'nurse');
            }

            radios.forEach(radio => radio.addEventListener('change', updateFields));
            updateFields(); // run once on load to match the pre-checked radio
        });
    </script>

</body>
</html>