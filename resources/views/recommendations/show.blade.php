@extends('layouts.app')

@section('title', 'Recommendation Detail')

@php($active = 'recommendations')

@section('content')
<div class="pd-page">

    {{-- Patient / consultation header --}}
    <div class="pd-card pd-header">
        <div class="pd-header__left">
            <span class="pd-header__avatar"></span>
            <div>
                <h1>{{ $rec['patient_name'] }}</h1>
                <div class="pd-header__meta">
                    <span class="pd-header__id">Record #{{ $rec['dossier_id'] }}</span>
                    <span class="pd-header__status">Consultation on {{ $rec['consultation_date'] }}</span>
                </div>
                <div class="pd-header__sub">
                    <span>{{ $rec['age'] }} years</span>
                </div>
            </div>
        </div>

        <div class="pd-header__right">
            <div class="pd-header__doctor">
                <span>Responsible Doctor</span>
                <strong>{{ $rec['doctor'] }}</strong>
            </div>
        </div>
    </div>

    <div class="pd-main">

            {{-- Two summary boxes side by side --}}
            <div class="pd-clinical-grid">

                {{-- Box 1 : Clinical evaluation --}}
                <div class="pd-card">
                    <h2 class="pd-card__title">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="3" width="12" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        Clinical Evaluation
                    </h2>

                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Resectability</span>
                                <strong class="pd-clinical__value">{{ $rec['stage_label'] }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Performance Status (ECOG)</span>
                                <strong class="pd-clinical__value">{{ $rec['clinical']['performance_status'] }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">CA19-9</span>
                                <strong class="pd-clinical__value">{{ $rec['clinical']['ca19_9'] }} U/mL{{ $rec['clinical']['cholestasis'] ? ' (cholestasis present)' : '' }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Bilirubin</span>
                                <strong class="pd-clinical__value">{{ $rec['clinical']['bilirubin_elevated'] ? '≥ 1.5x ULN' : '< 1.5x ULN' }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Comorbidities / Surgical CI</span>
                                <strong class="pd-clinical__value">
                                    {{ ($rec['clinical']['severe_comorbidities'] || $rec['clinical']['surgical_contraindication']) ? 'Present' : 'None' }}
                                </strong>
                            </div>
                        </li>
                    </ul>
                </div>

                {{-- Box 2 : ABC stratification / risk factors --}}
                <div class="pd-card">
                    <h2 class="pd-card__title">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        ABC Stratification
                    </h2>

                    @if ($result['abc_type'])
                        <div class="pd-abc-type">
                            <span>Resectability Type</span>
                            <strong>{{ $result['abc_type'] }}</strong>
                        </div>
                    @else
                        <p class="pd-card__subtitle">Not applicable to this resectability category.</p>
                    @endif

                    <ul class="pd-clinical__col">
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Criterion B (Biological)</span>
                                <strong class="pd-clinical__value">CA19-9 &gt; 500 U/mL, no cholestasis &mdash; {{ (!$rec['clinical']['cholestasis'] && $rec['clinical']['ca19_9'] > 500) ? 'Present' : 'Absent' }}</strong>
                            </div>
                        </li>
                        <li>
                            <span class="pd-clinical__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></span>
                            <div>
                                <span class="pd-clinical__label">Criterion C (Clinical)</span>
                                <strong class="pd-clinical__value">ECOG &ge; 1 &mdash; {{ $rec['clinical']['performance_status'] >= 1 ? 'Present' : 'Absent' }}</strong>
                            </div>
                        </li>
                    </ul>

                    @if (!empty($result['transversal_note']))
                        <p class="pd-card__note">{{ $result['transversal_note'] }}</p>
                    @endif
                </div>

            </div>

            {{-- Large box: generated recommendation --}}
            <div class="pd-card pd-card--centered">
                <h2 class="pd-card__title pd-card__title--no-icon">Generated Recommendation</h2>
                <p class="pd-card__subtitle">Computed by the rule engine from the clinical evaluation above.</p>

                @if ($result['conflict'])
                    <div class="pd-conflict">
                        <strong>Ambiguous case &mdash; referred to RCP</strong>
                        <p>{{ $result['conflict_reason'] }}</p>
                    </div>
                @endif

                <div class="ce-table-wrap">
                    <table class="ce-table">
                        <thead>
                            <tr>
                                <th>Rule ID</th>
                                <th>Recommendation</th>
                                <th>Grade</th>
                                <th>Justification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="ce-table__rule-id">{{ $result['rule_id'] }}</span></td>
                                <td><span class="ce-table__result">{{ $result['recommendation'] }}</span></td>
                                <td>{{ $result['grade'] }}</td>
                                <td class="ce-table__justification">{{ $result['justification'] }}</td>
                            </tr>
                            @if ($result['overlay_rule'])
                            <tr>
                                <td><span class="ce-table__rule-id">{{ $result['overlay_rule']['rule_id'] }}</span></td>
                                <td><span class="ce-table__result">{{ $result['overlay_rule']['recommendation'] }}</span></td>
                                <td>{{ $result['overlay_rule']['grade'] }}</td>
                                <td class="ce-table__justification">{{ $result['overlay_rule']['justification'] }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="pd-justification">
                    <span>Source</span>
                    <strong>TNCD, Chapter 9, §{{ $result['source'] }}</strong>
                </div>
            </div>

    </div>

    {{-- Action bar --}}
    @if ($rec['status'] === 'rcp')
        <div class="pd-action-bar" style="grid-template-columns: 1fr 1.4fr;">
            <a href="{{ route('recommendations.index') }}" class="pd-btn pd-btn--outline">Back to List</a>
            @if ($rec['rcp_meeting_exists'])
                <a href="{{ route('rcp.show', $rec['id']) }}" class="pd-btn pd-btn--primary">View RCP Sheet</a>
            @else
                <a href="{{ route('rcp.create', $rec['id']) }}" class="pd-btn pd-btn--primary">Complete RCP Sheet</a>
            @endif
        </div>
    @else
    <div class="pd-action-bar">
        <a href="{{ route('recommendations.index') }}" class="pd-btn pd-btn--outline">Back to List</a>

        <form method="POST" action="{{ route('recommendations.reject', $rec['id']) }}">
            @csrf
            <button type="submit" class="pd-btn pd-btn--outline pd-btn--block">Reject</button>
        </form>

        <form method="POST" action="{{ route('recommendations.rcp', $rec['id']) }}">
            @csrf
            <button type="submit" class="pd-btn pd-btn--outline pd-btn--block">Send to RCP</button>
        </form>

        <form method="POST" action="{{ route('recommendations.validate', $rec['id']) }}">
            @csrf
            <button type="submit" class="pd-btn pd-btn--primary pd-btn--block">Validate Recommendation</button>
        </form>
    </div>
    @endif

</div>
@endsection
