<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — PDCA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="login-page">

        <div class="login-panel">
            <form class="login-form" method="POST" action="{{ route('password.update') }}">
                @csrf

                <h1 style="margin-bottom:8px;">Choose a new password</h1>

                @if ($errors->any())
                    <div class="login-form__error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="login-field">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.5 0 4.5-2 4.5-4.5S14.5 3 12 3 7.5 5 7.5 7.5 9.5 12 12 12Z" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M4 20.5c0-3.6 3.6-6.5 8-6.5s8 2.9 8 6.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $email) }}"
                        placeholder="Enter your email"
                        autocomplete="email"
                        required
                        autofocus
                    >
                </div>

                <div class="login-field">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="10.5" width="14" height="9.5" rx="2" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M8 10.5V7.5a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    <input
                        type="password"
                        name="password"
                        placeholder="New password"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="login-field">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="5" y="10.5" width="14" height="9.5" rx="2" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M8 10.5V7.5a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="login-form__submit">Reset password</button>
            </form>
        </div>

        <div class="login-visual"></div>

    </div>

</body>
</html>