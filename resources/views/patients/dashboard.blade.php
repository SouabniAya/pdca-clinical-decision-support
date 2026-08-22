@extends('layouts.app')

@section('title', 'Dashboard')

@php($active = 'dashboard')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-page__head">
        <div>
            <h1>Dashboard</h1>
            <p>Overview of patients, recommendations, and recent activity.</p>
        </div>
        <a href="{{ route('patients.index') }}" class="dashboard-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M2.5 19c0-3 2.9-4.7 6.5-4.7s6.5 1.7 6.5 4.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            View All Patients
        </a>
    </div>

    {{-- ================= Stat cards ================= --}}
    <div class="dashboard-stats">

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M2.5 19c0-3 2.9-4.7 6.5-4.7s6.5 1.7 6.5 4.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="16.5" cy="8.3" r="2.4" stroke="currentColor" stroke-width="1.6"/><path d="M14.6 19c.3-2.3 2.1-3.7 4.4-3.7s4.1 1.4 4.4 3.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Registered Patients</h3>
                <strong>128</strong>
                <span>Total patients</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Active Patients</h3>
                <strong>96</strong>
                <span>Currently active</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Recommendations</h3>
                <strong>15</strong>
                <span>Awaiting review</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>New Patients</h3>
                <strong>8</strong>
                <span>This month</span>
            </div>
        </div>

    </div>

    {{-- ================= Chart + Activity ================= --}}
    <div class="dashboard-grid">

        <div class="dashboard-grid__col">

            {{-- Donut chart : patients by status --}}
            <div class="dashboard-card">
                <div class="dashboard-card__head">
                    <h2>Patients by Status</h2>
                    <span class="dashboard-card__subtitle">Distribution across all 128 patients</span>
                </div>

                <div class="dashboard-donut">
                    <svg viewBox="0 0 180 180" class="dashboard-donut__chart">
                        {{-- background track --}}
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-neutral-100)" stroke-width="22"/>

                        {{-- Active : 65% --}}
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-cerulean)" stroke-width="22"
                                stroke-dasharray="285.9 439.8" stroke-dashoffset="0"
                                stroke-linecap="round" transform="rotate(-90 90 90)"/>

                        {{-- Inactive : 20% --}}
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-sky)" stroke-width="22"
                                stroke-dasharray="87.96 439.8" stroke-dashoffset="-285.9"
                                stroke-linecap="round" transform="rotate(-90 90 90)"/>

                        {{-- Archived : 15% --}}
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-neutral-300)" stroke-width="22"
                                stroke-dasharray="65.97 439.8" stroke-dashoffset="-373.86"
                                stroke-linecap="round" transform="rotate(-90 90 90)"/>

                        <text x="90" y="84" text-anchor="middle" class="dashboard-donut__value">128</text>
                        <text x="90" y="104" text-anchor="middle" class="dashboard-donut__label">Patients</text>
                    </svg>

                    <ul class="dashboard-donut__legend">
                        <li><span class="dashboard-donut__dot" style="background: var(--color-cerulean)"></span>Active <strong>65%</strong></li>
                        <li><span class="dashboard-donut__dot" style="background: var(--color-sky)"></span>Inactive <strong>20%</strong></li>
                        <li><span class="dashboard-donut__dot" style="background: var(--color-neutral-300)"></span>Archived <strong>15%</strong></li>
                    </ul>
                </div>
            </div>

            {{-- Recommendations to review --}}
            <div class="dashboard-card">
                <div class="dashboard-card__head">
                    <h2>Recommendations to Review</h2>
                    <span class="dashboard-card__subtitle">15 recommendations awaiting clinician validation</span>
                </div>

                <ul class="dashboard-recos">

                    <li class="dashboard-recos__item">
                        <div class="dashboard-recos__info">
                            <strong>Yasmine Cherif</strong>
                            <span>Suggested: Neoadjuvant chemotherapy &middot; Locally Advanced</span>
                        </div>
                        <a href="{{ route('patients.details', 1) }}" class="dashboard-recos__action">Review</a>
                    </li>

                    <li class="dashboard-recos__item">
                        <div class="dashboard-recos__info">
                            <strong>Karim Ferhat</strong>
                            <span>Suggested: Surgical resection &middot; Localized</span>
                        </div>
                        <a href="{{ route('patients.details', 1) }}" class="dashboard-recos__action">Review</a>
                    </li>

                    <li class="dashboard-recos__item">
                        <div class="dashboard-recos__info">
                            <strong>Sofia Amrani</strong>
                            <span>Suggested: Radiotherapy &middot; Metastatic</span>
                        </div>
                        <a href="{{ route('patients.details', 1) }}" class="dashboard-recos__action">Review</a>
                    </li>

                    <li class="dashboard-recos__item">
                        <div class="dashboard-recos__info">
                            <strong>Mohamed Larbi</strong>
                            <span>Suggested: Follow-up imaging &middot; Locally Advanced</span>
                        </div>
                        <a href="{{ route('patients.details', 1) }}" class="dashboard-recos__action">Review</a>
                    </li>

                </ul>

                <a href="{{ route('patients.index') }}" class="dashboard-activity__view-all">View All Recommendations</a>
            </div>

        </div>

        {{-- Recent activity (right column) --}}
        <div class="dashboard-card dashboard-card--activity">
            <div class="dashboard-card__head">
                <h2>Recent Activity</h2>
                <span class="dashboard-card__subtitle">Latest updates across patient records</span>
            </div>

            <ul class="dashboard-activity">

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--update">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20l4-1 10-10-3-3L5 16l-1 4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p><strong>Ahmed Benali</strong>'s clinical data was updated</p>
                        <span>Stage changed to Locally Advanced &middot; 2 hours ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--recommendation">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p>New recommendation generated for <strong>Yasmine Cherif</strong></p>
                        <span>Awaiting clinician review &middot; 5 hours ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--new">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p>New patient <strong>Karim Ferhat</strong> was registered</p>
                        <span>Added by Dr. Meziane &middot; 1 day ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--status">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p><strong>Sofia Amrani</strong>'s status changed to Active</p>
                        <span>Previously Inactive &middot; 1 day ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--update">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20l4-1 10-10-3-3L5 16l-1 4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p><strong>Mohamed Larbi</strong>'s exam results were updated</p>
                        <span>New lab results attached &middot; 2 days ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--recommendation">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p>New recommendation generated for <strong>Karim Ferhat</strong></p>
                        <span>Awaiting clinician review &middot; 2 days ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--status">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p><strong>Nadia Boukhalfa</strong>'s status changed to Archived</p>
                        <span>Treatment completed &middot; 3 days ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--new">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p>New patient <strong>Leila Haddad</strong> was registered</p>
                        <span>Added by Dr. Belkacem &middot; 3 days ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--update">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20l4-1 10-10-3-3L5 16l-1 4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p><strong>Yasmine Cherif</strong>'s clinical data was updated</p>
                        <span>Age and exam results corrected &middot; 4 days ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--status">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p><strong>Ahmed Benali</strong>'s status changed to Active</p>
                        <span>Previously Inactive &middot; 4 days ago</span>
                    </div>
                </li>

                <li class="dashboard-activity__item">
                    <span class="dashboard-activity__icon dashboard-activity__icon--recommendation">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="dashboard-activity__body">
                        <p>New recommendation generated for <strong>Sofia Amrani</strong></p>
                        <span>Awaiting clinician review &middot; 5 days ago</span>
                    </div>
                </li>

            </ul>

            <a href="{{ route('patients.index') }}" class="dashboard-activity__view-all">View All Patients</a>
        </div>

    </div>

</div>
@endsection