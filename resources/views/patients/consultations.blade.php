@extends('layouts.app')

@section('title', 'Consultation History')

@php($active = 'patients')

@section('content')
<div class="pd-page">

    <div class="pd-card pd-header" style="justify-content:space-between;">
        <div>
            <h1 style="margin:0;">{{ $patient->first_name }} {{ $patient->last_name }}</h1>
            <p style="color:#6b7280;font-size:14px;margin:4px 0 0;">Consultation history — every clinical evaluation on record.</p>
        </div>
        <a href="{{ route('patients.show', $patient->patient_id) }}" class="pd-btn pd-btn--outline">
            &larr; Back to Patient
        </a>
    </div>

    <div class="pd-card" style="margin-top:20px;padding:0;overflow:hidden;">
        <table class="patients-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>ECOG</th>
                    <th>Resectability</th>
                    <th>CA19-9</th>
                    <th>Recommendation</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($consultations as $consultation)
                    @php
                        $rec = $consultation->recommendations->sortByDesc('generation_date')->first();
                        $doctorUser = $consultation->doctor->user ?? null;
                    @endphp
                    <tr>
                        <td>{{ optional($consultation->consultation_date)->format('d/m/Y H:i') ?? '—' }}</td>
                        <td>{{ $doctorUser ? 'Dr. ' . trim($doctorUser->first_name . ' ' . $doctorUser->last_name) : 'Unassigned' }}</td>
                        <td>{{ $consultation->performance_status ?? '—' }}</td>
                        <td>{{ $consultation->tumorEvaluation ? ucfirst(str_replace('_', ' ', $consultation->tumorEvaluation->resectability)) : '—' }}</td>
                        <td>{{ $consultation->tumorEvaluation->ca19_9_level ?? '—' }}</td>
                        <td>
                            @if ($rec)
                                <a href="{{ route('recommendations.show', $rec->recommendation_id) }}" class="pd-link">
                                    {{ $rec->rule_id }} &middot; {{ $rec->status_label }}
                                </a>
                            @else
                                <span style="color:#6b7280;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#6b7280;padding:32px;">
                            No consultations recorded yet for this patient.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
