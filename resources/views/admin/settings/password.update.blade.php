<section id="password" class="settings-card">

    <div class="settings-card__head">
        <div>
            <h2>Password</h2>
            <p>Choose a strong password you don't use elsewhere.</p>
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

            <div class="settings-form__field settings-form__field--full">
                <label for="current_password">
                    Current Password
                </label>

                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                >
            </div>

            <div class="settings-form__field">
                <label for="new_password">
                    New Password
                </label>

                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    required
                >
            </div>

            <div class="settings-form__field">
                <label for="new_password_confirmation">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    id="new_password_confirmation"
                    name="new_password_confirmation"
                    required
                >
            </div>

        </div>

        <div class="settings-note">
            <p>
                Use at least 8 characters, including a number
                and an uppercase letter.
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