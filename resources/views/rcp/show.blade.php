@extends('layouts.app')

@section('title', 'RCP Sheet')

@php($active = 'recommendations')

@section('content')
<div class="pd-page">

    <div class="pd-card pd-header">
        <div class="pd-header__left">
            <span class="pd-header__avatar"></span>
            <div>
                <h1>{{ trim($rec->consultation->patient->first_name . ' ' . $rec->consultation->patient->last_name) }}</h1>
                <div class="pd-header__meta">
                    <span class="pd-header__id">RCP Meeting — {{ $meeting->meeting_date->format('d/m/Y') }}</span>
                    <span class="crr-badge crr-badge--active">Completed</span>
                </div>
            </div>
        </div>
        <div class="pd-header__right">
            <a href="{{ route('recommendations.show', $rec->recommendation_id) }}" class="pd-btn pd-btn--outline pd-btn--sm">Back to Recommendation</a>
        </div>
    </div>

    @if (session('success'))
        <div class="crr-alert crr-alert--success" style="max-width:960px; margin:0 auto 0;">{{ session('success') }}</div>
    @endif

    <div class="pd-main" style="max-width:960px; margin:0 auto; width:100%;">

        <div class="pd-card">
            <h2 class="pd-card__title pd-card__title--no-icon">Original Engine Recommendation</h2>
            <p><strong>{{ $rec->rule_id }}</strong> — {{ $rec->recommendation_text }}</p>
            <p class="pd-card__note">{{ $rec->justification }}</p>
        </div>

        <div class="pd-card">
            <h2 class="pd-card__title pd-card__title--no-icon">Participants</h2>
            <p>{{ $meeting->participants }}</p>
        </div>

        <div class="pd-card">
            <h2 class="pd-card__title pd-card__title--no-icon">Final Decision</h2>
            <p>{{ $meeting->final_decision }}</p>

            @if ($meeting->deviates_from_recommendation)
                <div class="pd-conflict">
                    <strong>Deviates from the engine's recommendation</strong>
                    <p>{{ $meeting->deviation_reason }}</p>
                </div>
            @else
                <p class="pd-card__note">This decision matches the engine's original recommendation.</p>
            @endif

            @if ($meeting->notes)
                <p class="pd-card__note">{{ $meeting->notes }}</p>
            @endif
        </div>

    </div>

</div>
@endsection
