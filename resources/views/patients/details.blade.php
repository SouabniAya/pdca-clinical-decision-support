@extends('layouts.app')

@section('title', 'Patient Details')

@php($active = 'patients')

{{-- $latest (most recent consultation, or null) is now passed in from PatientController::show --}}

@section('content')
<div class="pd-page">

    {{-- Patient header card --}}
    <div class="pd-card pd-header">
        <div class="pd-header__left">
            <span class="pd-header__avatar"></span>
            <div>
                <h1>{{ $patient->first_name }} {{ $patient->last_name }}</h1>
                <div class="pd-header__meta">
                    <span class="pd-header__id">ID: P{{ str_pad($patient->patient_id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span class="pd-header__status">{{ ucfirst($patient->status) }}</span>
                </div>
                <div class="pd-header__sub">
                    <span>{{ $patient->age }} years</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="14" r="5" stroke="currentColor" stroke-width="1.6"/><path d="M14 10l6-6M14 4h6v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>{{ $patient->date_of_birth->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <div class="pd-header__right">
            <div class="pd-header__doctor">
                <span>Responsible Doctor</span>
                <strong>{{ $latest && $latest->doctor ? $latest->doctor->name : 'Unassigned' }}</strong>
            </div>
            <a href="{{ route('patients.edit', $patient->patient_id) }}" class="pd-btn pd-btn--outline">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 21h4l11-11-4-4L4 17v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                Edit Patient
            </a>
            <form method="POST" action="{{ route('patients.destroy', $patient->patient_id) }}" onsubmit="return confirm('Delete this patient? This cannot be undone.');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="pd-btn pd-btn--icon" aria-label="Delete patient">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 7h12M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m-8 0v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </form>
        </div>
    </div>

    <div class="pd-layout">

        {{-- Main column --}}
        <div class="pd-main">

            {{--
                Clinical Data Summary — now wired to $latest->tumorEvaluation and
                $latest->comorbidities. Distant Metastases, Vascular Involvement,
                and Weight/BMI stay as '—' because those columns don't exist yet
                in tumor_evaluation — add them via migration if you need to track them.
            --}}
            <div class="pd-card">
                <h2 class="pd-card__title">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="3" width="12" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                    Clinical Data Summary
                </h2>

                               <div class="pd-clinical">
                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Resectability Status</span>
                                <strong class="pd-clinical__value">{{ $latest?->tumorEvaluation?->resectability ? ucfirst(str_replace('_', ' ', $latest->tumorEvaluation->resectability)) : '—' }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Clinical Stage</span>
                                <strong class="pd-clinical__value">{{ $latest->clinical_stage ?? '—' }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Performance Status (ECOG)</span>
                                <strong class="pd-clinical__value">{{ $latest->performance_status ?? '—' }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">CA19-9</span>
                                <strong class="pd-clinical__value">{{ $latest?->tumorEvaluation?->ca19_9_level ?? '—' }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Major Comorbidities</span>
                                <strong class="pd-clinical__value">
                                    @if ($latest && $latest->comorbidities->isNotEmpty())
                                        {{ $latest->comorbidities->map(fn ($c) => $c->label . ' (' . ucfirst($c->pivot->severity ?? '—') . ')')->implode(', ') }}
                                    @else
                                        —
                                    @endif
                                </strong>
                            </div>
                        </li>
                    </ul>
                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <div>
                                <span class="pd-clinical__label">Surgical Contraindications</span>
                                <strong class="pd-clinical__value">{{ $latest?->tumorEvaluation ? ($latest->tumorEvaluation->surgery_contraindication ? 'Yes' : 'No') : '—' }}</strong>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Consultations & Follow-up --}}
            <div class="pd-card">
                <div class="pd-consult__head">
                    <h2 class="pd-card__title pd-card__title--no-icon">Consultations &amp; Follow-up</h2>
                </div>

                @if ($latest)
                    <span class="pd-consult__upcoming-label">Latest Consultation</span>
                    <div class="pd-consult__box">
                        <strong>{{ optional($latest->consultation_date)->format('d/m/Y \\a\\t H:i') ?? '—' }}</strong>
                        <span>{{ $latest->department ?? 'Not specified' }}</span>
                        <span class="pd-consult__doctor">{{ $latest->doctor->name ?? 'Unassigned' }}</span>
                    </div>
                @else
                    <p style="color:#6b7280;font-size:14px;">No consultations recorded yet.</p>
                @endif
            </div>

        </div>

        {{-- Sidebar column --}}
        <aside class="pd-side">

            <div class="pd-card">
                <h2 class="pd-card__title pd-card__title--no-icon">Recommendation generated</h2>
                <p class="pd-card__subtitle">Based on patient data and clinical rules</p>

                @if ($latestRecommendation)
                    <p style="color:#111827;font-size:14px;font-weight:600;margin-bottom:4px;">
                        {{ $latestRecommendation->recommendation_text }}
                    </p>
                    <p style="color:#6b7280;font-size:13px;">
                        Status: {{ ucfirst($latestRecommendation->status) }}
                    </p>
                @else
                    <p style="color:#6b7280;font-size:14px;">No recommendation available yet for this patient.</p>
                @endif
            </div>

            {{--
                TODO: Modification History depends on an audit-log table
                that isn't in the schema yet. Replace with a real query
                (e.g. $patient->activityLog()->latest()->take(5)->get())
                once that table exists.
            --}}
                <div class="pd-card">
                <h2 class="pd-card__title">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Modification History
                </h2>

                @forelse ($activityLogs as $log)
                    <div style="padding:10px 0; border-bottom:1px solid #f1f1f1;">
                        <p style="font-size:13.5px; color:#111827; margin:0 0 2px;">{!! $log->message !!}</p>
                        <span style="font-size:12.5px; color:#6b7280;">
                            {{ $log->actor_name }}
                            @if ($log->detail)
                                &middot; {{ $log->detail }}
                            @endif
                            &middot; {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <p style="color:#6b7280;font-size:14px;">No activity history available yet.</p>
                @endforelse
            </div>

        </aside>

    </div>

</div>
@endsection