<section class="settings-card settings-card--danger">

    <div class="settings-card__head">
        <div>
            <h2>Danger Zone</h2>

            <p>
                Irreversible and destructive actions.
            </p>
        </div>
    </div>

    <div class="settings-danger-row">

        <div>
            <strong>
                Deactivate Account
            </strong>

            <span>
                You will lose access to the system until an admin
                reactivates your account.
            </span>
        </div>

        <form
            action="{{ route('settings.deactivate') }}"
            method="POST"
            onsubmit="return confirm('Are you sure you want to deactivate your account?');"
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