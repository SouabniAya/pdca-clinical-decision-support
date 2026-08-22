<section id="profile" class="settings-card">

    <div class="settings-card__head">
        <div>
            <h2>Profile Information</h2>
            <p>Update your name, email address, and contact details.</p>
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

            <div class="settings-form__field">
                <label for="first_name">
                    First Name
                </label>

                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    value="{{ old('first_name', $user->first_name ?? '') }}"
                    placeholder="Sara"
                    required
                >
            </div>

            <div class="settings-form__field">
                <label for="last_name">
                    Last Name
                </label>

                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    value="{{ old('last_name', $user->last_name ?? '') }}"
                    placeholder="Meziane"
                    required
                >
            </div>

            <div class="settings-form__field">
                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email ?? '') }}"
                    placeholder="sara.meziane@clinic.com"
                    required
                >
            </div>

            <div class="settings-form__field">
                <label for="phone">
                    Phone Number
                </label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone ?? '') }}"
                    placeholder="+213 555 000 000"
                >
            </div>

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
            </div>

            <div class="settings-form__field">
                <label for="role">
                    Role
                </label>

                <input
                    type="text"
                    id="role"
                    value="{{ $user->role ?? 'Clinician' }}"
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