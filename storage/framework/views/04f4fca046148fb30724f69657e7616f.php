<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in — PDCA</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>

    <div class="login-page">

        <span class="login-page__eyebrow">log in</span>

        <div class="login-panel">
            <form class="login-form" method="POST" action="<?php echo e(route('login.store')); ?>">
                <?php echo csrf_field(); ?>

                <?php if($errors->any()): ?>
                    <div class="login-form__error">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <div class="login-field">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.5 0 4.5-2 4.5-4.5S14.5 3 12 3 7.5 5 7.5 7.5 9.5 12 12 12Z" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M4 20.5c0-3.6 3.6-6.5 8-6.5s8 2.9 8 6.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    <input
                        type="text"
                        name="id"
                        value="<?php echo e(old('id')); ?>"
                        placeholder="Enter your id"
                        autocomplete="username"
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
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <div class="login-form__row">
                    <label class="login-form__remember">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="<?php echo e(route('password.request')); ?>" class="login-form__forgot">Forgot password?</a>
                </div>

                <button type="submit" class="login-form__submit">Login</button>

                <div class="login-form__divider">or sign in with google</div>

                <a href="<?php echo e(route('auth.google')); ?>" class="login-form__google">
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3c-1.6 4.6-6 8-11.3 8-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.5 6 29.5 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.2-.1-2.4-.4-3.5Z"/>
                        <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 15.9 18.9 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.5 6 29.5 4 24 4 16.3 4 9.6 8.3 6.3 14.7Z"/>
                        <path fill="#4CAF50" d="M24 44c5.4 0 10.3-1.9 14.1-5.4l-6.5-5.5C29.4 34.9 26.8 36 24 36c-5.3 0-9.7-3.4-11.3-8.1l-6.5 5C9.5 39.6 16.2 44 24 44Z"/>
                        <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4 5.5l6.5 5.5C41.4 36 44 30.5 44 24c0-1.2-.1-2.4-.4-3.5Z"/>
                    </svg>
                    Sign in with Google
                </a>
            </form>
        </div>

        <div class="login-visual"></div>

    </div>

</body>
</html>
<?php /**PATH C:\laragon\www\medcare-clone\resources\views/auth/login.blade.php ENDPATH**/ ?>