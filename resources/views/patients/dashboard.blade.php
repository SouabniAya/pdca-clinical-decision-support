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
                <strong>{{ $stats['total'] }}</strong>
                <span>Total patients</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Active Patients</h3>
                <strong>{{ $stats['active'] }}</strong>
                <span>Currently active</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>Recommendations</h3>
                <strong>{{ $stats['pending_recommendations'] }}</strong>
                <span>Awaiting review</span>
            </div>
        </div>

        <div class="dashboard-stat-card">
            <span class="dashboard-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </span>
            <div class="dashboard-stat-card__body">
                <h3>New Patients</h3>
                <strong>{{ $stats['new_this_month'] }}</strong>
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
                    <span class="dashboard-card__subtitle">Distribution across all {{ $statusBreakdown['total'] }} patients</span>
                </div>

                <div class="dashboard-donut">
                    <svg viewBox="0 0 180 180" class="dashboard-donut__chart">
                        {{-- background track --}}
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-neutral-100)" stroke-width="22"/>

                        {{-- Active --}}
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-cerulean)" stroke-width="22"
                                stroke-dasharray="{{ $statusBreakdown['active']['dasharray'] }} {{ $statusBreakdown['circumference'] }}"
                                stroke-dashoffset="0"
                                stroke-linecap="round" transform="rotate(-90 90 90)"/>

                        {{-- Inactive --}}
                        <circle cx="90" cy="90" r="70" fill="none" stroke="var(--color-sky)" stroke-width="22"
                                stroke-dasharray="{{ $statusBreakdown['inactive']['dasharray'] }} {{ $statusBreakdown['circumference'] }}"
                                stroke-dashoffset="-{{ $statusBreakdown['active']['dasharray'] }}"
                                stroke-linecap="round" transform="rotate(-90 90 90)"/>

                        <text x="90" y="84" text-anchor="middle" class="dashboard-donut__value">{{ $statusBreakdown['total'] }}</text>
                        <text x="90" y="104" text-anchor="middle" class="dashboard-donut__label">Patients</text>
                    </svg>

                    <ul class="dashboard-donut__legend">
                        <li><span class="dashboard-donut__dot" style="background: var(--color-cerulean)"></span>Active <strong>{{ $statusBreakdown['active']['pct'] }}%</strong></li>
                        <li><span class="dashboard-donut__dot" style="background: var(--color-sky)"></span>Inactive <strong>{{ $statusBreakdown['inactive']['pct'] }}%</strong></li>
                    </ul>
                </div>
            </div>

            {{-- Recommendations to review --}}
            <div class="dashboard-card">
                <div class="dashboard-card__head">
                    <h2>Recommendations to Review</h2>
                    <span class="dashboard-card__subtitle">{{ $stats['pending_recommendations'] }} recommendations awaiting clinician validation</span>
                </div>

                <ul class="dashboard-recos">

                    @forelse ($pendingRecommendations as $item)
                        <li class="dashboard-recos__item">
                            <div class="dashboard-recos__info">
                                <strong>{{ $item['patient_name'] }}</strong>
                                <span>
                                    Suggested: {{ $item['recommendation_text'] ?? 'Pending analysis' }}
                                    @if ($item['stage'])
                                        &middot; {{ $item['stage'] }}
                                    @endif
                                </span>
                            </div>
                            <a href="{{ route('recommendations.show', $item['id']) }}" class="dashboard-recos__action">Review</a>
                        </li>
                    @empty
                        <li class="dashboard-recos__item">
                            <div class="dashboard-recos__info">
                                <span>No recommendations awaiting review.</span>
                            </div>
                        </li>
                    @endforelse

                </ul>

                <a href="{{ route('recommendations.index') }}" class="dashboard-activity__view-all">View All Recommendations</a>
            </div>

        </div>

        {{-- Recent activity (right column) --}}
        <div class="dashboard-card dashboard-card--activity">
            <div class="dashboard-card__head">
                <h2>Recent Activity</h2>
                <span class="dashboard-card__subtitle">Latest updates across patient records</span>
            </div>

            <ul class="dashboard-activity">

                @forelse ($recentActivity as $activity)
                    <li class="dashboard-activity__item">
                        <span class="dashboard-activity__icon dashboard-activity__icon--{{ $activity->icon }}">
                            @switch($activity->icon)
                                @case('new')
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @break
                                @case('recommendation')
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @break
                                @case('status')
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @break
                                @default
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20l4-1 10-10-3-3L5 16l-1 4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            @endswitch
                        </span>
                        <div class="dashboard-activity__body">
                            <p>{!! $activity->message !!}</p>
                            <span>
                                @if ($activity->detail)
                                    {{ $activity->detail }} &middot;
                                @endif
                                {{ $activity->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="dashboard-activity__item">
                        <div class="dashboard-activity__body">
                            <p>No recent activity yet.</p>
                        </div>
                    </li>
                @endforelse

            </ul>

            <a href="{{ route('patients.index') }}" class="dashboard-activity__view-all">View All Patients</a>
        </div>

    </div>

</div>
@endsection