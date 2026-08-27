@extends('layouts.app')

@section('title', 'Clinical Explanation')

@php($active = 'patients')

@section('content')
<div class="ce-page">

    <div class="ce-page__head">
        <div>
            <h1>Clinical Explanation</h1>
            <p>This page presents the clinical rule applied, the decision path followed, and the medical justification for the generated recommendation.</p>
        </div>

        <div class="ce-patient-card">
            <span class="ce-patient-card__avatar"></span>
            <div class="ce-patient-card__body">
                <strong>{{ trim($patient->first_name . ' ' . $patient->last_name) }}</strong>
                <div class="ce-patient-card__meta">
                    <span class="ce-patient-card__id">ID: P{{ str_pad($patient->patient_id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span class="ce-patient-card__status">{{ ucfirst($patient->status ?? 'active') }}</span>
                    <span class="ce-patient-card__age">{{ $patient->age }} years</span>
                    <span>{{ $patient->date_of_birth?->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    @if (!$recommendation)

        <div class="ce-card">
            <h2 class="ce-card__title">No Recommendation Yet</h2>
            <p style="color:#6b7280;">This patient has no clinical evaluation on record, so no rule has been applied yet.</p>
            <a href="{{ route('clinical-data.edit', $patient->patient_id) }}" class="pd-btn pd-btn--primary" style="display:inline-flex; margin-top:12px;">Add Clinical Data</a>
        </div>

    @else

        <div class="ce-card">
            <h2 class="ce-card__title">Applied Clinical Rule</h2>

            <div class="ce-table-wrap">
                <table class="ce-table">
                    <thead>
                        <tr>
                            <th>Rule ID</th>
                            <th>Clinical Rule</th>
                            <th>Result</th>
                            <th>Justification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#" onclick="event.preventDefault();" class="ce-table__rule-id">{{ $recommendation->rule_id }}</a></td>
                            <td>{{ $recommendation->recommendation_text }}</td>
                            <td><span class="ce-table__result">Applied</span></td>
                            <td class="ce-table__justification">{{ $recommendation->justification }}</td>
                        </tr>

                        @if (!empty($recommendation->details['overlay_rule']))
                        <tr>
                            <td><span class="ce-table__rule-id">{{ $recommendation->details['overlay_rule']['rule_id'] }}</span></td>
                            <td>{{ $recommendation->details['overlay_rule']['recommendation'] }}</td>
                            <td><span class="ce-table__result">Applied (overlay)</span></td>
                            <td class="ce-table__justification">{{ $recommendation->details['overlay_rule']['justification'] }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($recommendation->conflict)
                <div class="pd-conflict" style="margin-top:16px;">
                    <strong>Ambiguous case — referred to RCP</strong>
                    <p>{{ $recommendation->conflict_reason }}</p>
                </div>
            @endif
        </div>

        <div class="ce-justification">
            <h3>Clinical Justification for the Recommendation</h3>
            <p>
                According to {{ $recommendation->source ?? 'TNCD' }}
                (grade {{ $recommendation->grade ?? 'N/A' }}),
                {{ $recommendation->justification }}
            </p>

            @if (!empty($recommendation->details['transversal_note']))
                <p style="margin-top:10px; color:#6b7280;">{{ $recommendation->details['transversal_note'] }}</p>
            @endif
        </div>

        <div style="max-width:960px; margin:20px auto 0;">
            <a href="{{ route('recommendations.show', $recommendation->recommendation_id) }}" class="pd-btn pd-btn--outline">View Full Recommendation</a>
        </div>

    @endif

</div>
@endsection
