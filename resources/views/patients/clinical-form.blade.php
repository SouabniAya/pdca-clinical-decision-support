@extends('layouts.app')

@section('title', 'Clinical Data Entry')

@php($active = 'clinical-data')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>Clinical Data Entry</h1>
            @if (!empty($patient))
                <p>Record or update the clinical assessment for {{ $patient['name'] }} — resectability, performance status, CA19-9 and comorbidities.</p>
            @else
                <p>Choose a patient below, then record their clinical assessment — resectability, performance status, CA19-9 and comorbidities.</p>
            @endif
        </div>
        @if (!empty($patient))
        <a href="{{ url('/patients/' . $patient['id']) }}" class="patients-page__btn patients-page__btn--ghost">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Patient File
        </a>
        @endif
    </div>

    <form class="clinical-form" method="POST" action="{{ !empty($patient) ? route('clinical-data.store', ['id' => $patient['id']]) : route('clinical-data.storeAny') }}">
        @csrf
        @if (!empty($evaluation))
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="clinical-form__error">{{ $errors->first() }}</div>
        @endif

        @if (empty($patient))
        {{-- Patient selection --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.6"/><path d="M5 20c0-3.6 3.1-6 7-6s7 2.4 7 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <h2>Patient</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field clinical-form__field--full">
                    <label for="patient_id">Select patient</label>
                    <select id="patient_id" name="patient_id" required>
                        <option value="">Select a patient...</option>
                        @foreach (($patients ?? []) as $p)
                            <option value="{{ $p['id'] }}" @selected(old('patient_id') == $p['id'])>
                                {{ $p['name'] }} — {{ $p['mrn'] }}
                            </option>
                        @endforeach
                    </select>
                    @if (empty($patients))
                        <p class="clinical-form__empty">No patients on record yet — add one from the Patients page first.</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Consultation --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12h8M8 15h8M8 18h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <h2>Consultation</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="consultation_date">Consultation date</label>
                    <input
                        type="date"
                        id="consultation_date"
                        name="consultation_date"
                        value="{{ old('consultation_date', $evaluation['consultation_date'] ?? '') }}"
                        required
                    >
                </div>

                <div class="clinical-form__field">
                    <label for="performance_status">Performance status (ECOG / WHO)</label>
                    <select id="performance_status" name="performance_status" required>
                        <option value="">Select...</option>
                        <option value="0" @selected(old('performance_status', $evaluation['performance_status'] ?? '') == '0')>0 — Fully active</option>
                        <option value="1" @selected(old('performance_status', $evaluation['performance_status'] ?? '') == '1')>1 — Restricted in strenuous activity</option>
                        <option value="2" @selected(old('performance_status', $evaluation['performance_status'] ?? '') == '2')>2 — Ambulatory, up &gt;50% of waking hours</option>
                        <option value="3" @selected(old('performance_status', $evaluation['performance_status'] ?? '') == '3')>3 — Limited self-care, in bed &gt;50%</option>
                        <option value="4" @selected(old('performance_status', $evaluation['performance_status'] ?? '') == '4')>4 — Completely disabled</option>
                    </select>
                </div>

                <div class="clinical-form__field">
                    <label for="clinical_stage">Clinical stage</label>
                    <input
                        type="text"
                        id="clinical_stage"
                        name="clinical_stage"
                        placeholder="e.g. cT3N1M0"
                        value="{{ old('clinical_stage', $evaluation['clinical_stage'] ?? '') }}"
                    >
                </div>
            </div>
        </div>

        {{-- Tumor evaluation --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <h2>Tumor Evaluation</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="resectability">Resectability status</label>
                    <select id="resectability" name="resectability" required>
                        <option value="">Select...</option>
                        <option value="resectable" @selected(old('resectability', $evaluation['resectability'] ?? '') == 'resectable')>Resectable</option>
                        <option value="borderline" @selected(old('resectability', $evaluation['resectability'] ?? '') == 'borderline')>Borderline</option>
                        <option value="locally_advanced" @selected(old('resectability', $evaluation['resectability'] ?? '') == 'locally_advanced')>Locally advanced</option>
                        <option value="metastatic" @selected(old('resectability', $evaluation['resectability'] ?? '') == 'metastatic')>Metastatic</option>
                    </select>
                </div>

                <div class="clinical-form__field">
                    <label for="ca19_9">CA19-9 level (U/mL)</label>
                    <input
                        type="number"
                        step="0.1"
                        min="0"
                        id="ca19_9"
                        name="ca19_9"
                        placeholder="e.g. 320.5"
                        value="{{ old('ca19_9', $evaluation['ca19_9'] ?? '') }}"
                    >
                </div>

                <div class="clinical-form__field">
                    <label for="ca19_9_date">CA19-9 measurement date</label>
                    <input
                        type="date"
                        id="ca19_9_date"
                        name="ca19_9_date"
                        value="{{ old('ca19_9_date', $evaluation['ca19_9_date'] ?? '') }}"
                    >
                </div>

                <div class="clinical-form__field clinical-form__field--checkbox">
                    <label class="clinical-form__checkbox">
                        <input type="checkbox" name="cholestasis" value="1" @checked(old('cholestasis', $evaluation['cholestasis'] ?? false))>
                        Cholestasis present <span>(affects CA19-9 interpretability)</span>
                    </label>
                </div>

                <div class="clinical-form__field clinical-form__field--checkbox">
                    <label class="clinical-form__checkbox">
                        <input type="checkbox" name="surgical_contraindication" value="1" @checked(old('surgical_contraindication', $evaluation['surgical_contraindication'] ?? false))>
                        Surgical contraindication
                    </label>
                </div>
            </div>
        </div>

        {{-- Comorbidities --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s-7-4.4-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6c-2.5 4.6-9.5 9-9.5 9Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                <h2>Comorbidities</h2>
            </div>
            <div class="clinical-form__comorbidities">
                @forelse (($comorbidities ?? []) as $comorbidity)
                <div class="clinical-form__comorbidity-row">
                    <label class="clinical-form__checkbox">
                        <input
                            type="checkbox"
                            name="comorbidities[]"
                            value="{{ $comorbidity['id'] }}"
                            @checked(in_array($comorbidity['id'], old('comorbidities', $selectedComorbidities ?? [])))
                        >
                        {{ $comorbidity['label'] }}
                    </label>
                    <select name="severity[{{ $comorbidity['id'] }}]">
                        <option value="">Severity</option>
                        <option value="mild">Mild</option>
                        <option value="moderate">Moderate</option>
                        <option value="severe">Severe</option>
                    </select>
                </div>
                @empty
                <p class="clinical-form__empty">No comorbidities on record for this patient yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Notes --}}
        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19V5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                <h2>Additional Notes</h2>
            </div>
            <div class="clinical-form__field clinical-form__field--full">
                <textarea id="comment" name="comment" rows="4" placeholder="Optional clinical remarks...">{{ old('comment', $evaluation['comment'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="clinical-form__actions">
            <a href="{{ !empty($patient) ? url('/patients/' . $patient['id']) : url('/patients') }}" class="clinical-form__cancel">Cancel</a>
            <button type="submit" class="clinical-form__submit">Save Clinical Data</button>
        </div>
    </form>

</div>
@endsection
