<header class="app-header">

    {{-- ================= Search ================= --}}
    <form method="GET" action="{{ route('patients.index') }}" class="app-header__search">
        <svg
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
        >
            <circle
                cx="11"
                cy="11"
                r="7"
                stroke="currentColor"
                stroke-width="2"
            />

            <path
                d="M21 21l-4.3-4.3"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            />
        </svg>

        <input
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search..."
            aria-label="Search"
        >
    </form>


    {{-- ================= Right side ================= --}}
    <div class="app-header__right">

        {{-- Notifications --}}
        <button
            type="button"
            class="app-header__icon-btn"
            aria-label="Notifications"
        >
            <svg
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                <path
                    d="M12 3a5 5 0 0 0-5 5v3.2c0 .6-.2 1.2-.6 1.7L5 15h14l-1.4-2.1a2.8 2.8 0 0 1-.6-1.7V8a5 5 0 0 0-5-5Z"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linejoin="round"
                />

                <path
                    d="M9.5 18a2.5 2.5 0 0 0 5 0"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                />
            </svg>

            {{-- Notification badge --}}
            <span class="app-header__badge"></span>
        </button>

        {{-- ================= User profile ================= --}}
        @php
            $currentUser = auth()->guard('web')->user() ?? auth()->guard('admin')->user();
            $fullName = $currentUser
                ? trim($currentUser->first_name . ' ' . $currentUser->last_name)
                : 'Guest';
        @endphp

        <a
                href="{{ route('profile') }}"
            class="app-header__profile"
            aria-label="View profile"
        >

            {{-- Avatar --}}
            <span class="app-header__avatar">
                <img
                    src="{{ $currentUser && $currentUser->profile_photo ? asset('storage/' . $currentUser->profile_photo) : asset('images/default-avatar.jpg') }}"
                    alt="{{ $fullName }}"
                >
            </span>

            {{-- Name --}}
            <span class="app-header__profile-name">
                {{ $fullName }}
            </span>

            {{-- Arrow --}}
            <svg
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                <path
                    d="M6 9l6 6 6-6"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

        </a>

    </div>

</header>