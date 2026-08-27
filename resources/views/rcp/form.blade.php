@extends('layouts.app')

@section('title', 'RCP Sheet')

@php($active = 'recommendations')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>RCP Meeting Sheet</h1>
            <p>
                Record the multidisciplinary team meeting decision for
                {{ trim($rec->consultation->patient->first_name . ' ' . $rec->consultation->patient->last_name) }}.
            </p>
        </div>
        <a href="{{ route('recommendations.show', $rec->recommendation_id) }}" class="patients-page__btn patients-page__btn--ghost">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Recommendation
        </a>
    </div>

    <div class="pd-card" style="max-width:900px; margin:0 auto 20px;">
        <h2 class="pd-card__title pd-card__title--no-icon">Original Engine Recommendation</h2>
        <p class="pd-card__subtitle">For reference, while recording the RCP's final decision below.</p>
        <p><strong>{{ $rec->rule_id }}</strong> — {{ $rec->recommendation_text }}</p>
        @if ($rec->conflict)
            <p class="pd-card__note">{{ $rec->conflict_reason }}</p>
        @endif
    </div>

    <form class="clinical-form" method="POST" action="{{ route('rcp.store', $rec->recommendation_id) }}" style="max-width:900px; margin:0 auto;">
        @csrf

        @if ($errors->any())
            <div class="clinical-form__error">{{ $errors->first() }}</div>
        @endif

        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="5" width="16" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M4 10h16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <h2>Meeting</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="meeting_date">Meeting date</label>
                    <input type="date" id="meeting_date" name="meeting_date" value="{{ old('meeting_date') }}" required>
                </div>

                <div class="clinical-form__field clinical-form__field--full">
                    <label for="participants">Participants</label>
                    <textarea id="participants" name="participants" rows="2" placeholder="e.g. Dr. Souabni (Oncology), Dr. Taieb (Surgery), Dr. Kaci (Radiology)..." required>{{ old('participants') }}</textarea>
                </div>
            </div>
        </div>

        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg>
                <h2>Decision</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field clinical-form__field--full">
                    <label for="final_decision">Final decision</label>
                    <textarea id="final_decision" name="final_decision" rows="3" placeholder="The treatment decision agreed by the multidisciplinary team..." required>{{ old('final_decision') }}</textarea>
                </div>

                <div class="clinical-form__field clinical-form__field--checkbox">
                    <label class="clinical-form__checkbox">
                        <input type="checkbox" id="deviates" name="deviates_from_recommendation" value="1" onchange="document.getElementById('deviation-reason-field').style.display = this.checked ? 'block' : 'none';" @checked(old('deviates_from_recommendation'))>
                        This decision deviates from the engine's recommendation
                    </label>
                </div>

                <div class="clinical-form__field clinical-form__field--full" id="deviation-reason-field" style="display: {{ old('deviates_from_recommendation') ? 'block' : 'none' }};">
                    <label for="deviation_reason">Reason for deviation</label>
                    <textarea id="deviation_reason" name="deviation_reason" rows="2" placeholder="Why the team's decision differs from the system's recommendation...">{{ old('deviation_reason') }}</textarea>
                </div>

                <div class="clinical-form__field clinical-form__field--full">
                    <label for="notes">Additional notes</label>
                    <textarea id="notes" name="notes" rows="2" placeholder="Optional...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="clinical-form__actions">
            <a href="{{ route('recommendations.show', $rec->recommendation_id) }}" class="clinical-form__cancel">Cancel</a>
            <button type="submit" class="clinical-form__submit">Save RCP Sheet</button>
        </div>
    </form>

</div>
@endsection
