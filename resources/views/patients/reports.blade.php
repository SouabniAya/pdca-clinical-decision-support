@extends('layouts.app')

@section('title', 'Reports')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/reports.css') }}">
@endpush

@section('content')

<div class="rp-page">

    {{-- ============================================================
         PAGE HEADER
    ============================================================ --}}
    <div class="rp-header">

        <div class="rp-header__left">
            <h1>Reports</h1>
            <p class="rp-header__sub">
                Analytics and exportable reports on patients,
                recommendations and clinical activity
            </p>
        </div>

        <div class="rp-header__right">

            <button type="button" class="pd-btn pd-btn--outline">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 9-9"/>
                    <path d="M3 4v8h8"/>
                </svg>
                Refresh
            </button>

           <button type="button" id="rp-export-btn" class="pd-btn pd-btn--primary">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">
                    <path d="M12 3v12"/>
                    <path d="M7 10l5 5 5-5"/>
                    <path d="M5 21h14"/>
                </svg>
                Export
            </button>

        </div>
    </div>


    {{-- ============================================================
         FILTERS
    ============================================================ --}}
    <div class="pd-card rp-filters">

        <div class="rp-filters__group">
            <label for="rp-date-from">From</label>
            <input
                type="date"
                id="rp-date-from"
                name="date_from"
            >
        </div>

        <div class="rp-filters__group">
            <label for="rp-date-to">To</label>
            <input
                type="date"
                id="rp-date-to"
                name="date_to"
            >
        </div>

        <div class="rp-filters__group">
            <label for="rp-report-type">Report type</label>

            <select id="rp-report-type" name="report_type">
                <option value="">All types</option>
                <option value="patients">Patients</option>
                <option value="recommendations">Recommendations</option>
                <option value="consultations">Consultations</option>
                <option value="audit">Audit / Activity</option>
            </select>
        </div>

        <div class="rp-filters__group">
            <label for="rp-doctor">Doctor</label>

            <select id="rp-doctor" name="doctor">
                <option value="">All doctors</option>

                @foreach($doctors ?? [] as $doctor)

                    <option value="{{ data_get($doctor, 'id') }}">
                        {{ data_get($doctor, 'name') }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="rp-filters__actions">

            <button
                type="button"
                class="pd-btn pd-btn--primary pd-btn--sm">
                Apply filters
            </button>

            <button
                type="button"
                class="pd-btn pd-btn--outline pd-btn--sm">
                Reset
            </button>

        </div>

    </div>


    {{-- ============================================================
         STATISTICS
    ============================================================ --}}
    <div class="rp-stats">

        {{-- Total patients --}}
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Total patients
                </span>

                <strong class="rp-stat__value">
                    {{ $stats['total_patients'] ?? '—' }}
                </strong>

            </div>

        </div>


        {{-- Recommendations --}}
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Recommendations generated
                </span>

                <strong class="rp-stat__value">
                    {{ $stats['total_recommendations'] ?? '—' }}
                </strong>

            </div>

        </div>


        {{-- Consultations --}}
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4"/>
                    <path d="M8 2v4"/>
                    <path d="M3 10h18"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Consultations scheduled
                </span>

                <strong class="rp-stat__value">
                    {{ $stats['total_consultations'] ?? '—' }}
                </strong>

            </div>

        </div>


        {{-- Conflicts --}}
        <div class="pd-card rp-stat">

            <div class="rp-stat__icon">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     aria-hidden="true">

                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>

                </svg>
            </div>

            <div class="rp-stat__body">

                <span class="rp-stat__label">
                    Conflicts flagged
                </span>

                <strong class="rp-stat__value">
                    {{ $stats['total_conflicts'] ?? '—' }}
                </strong>

            </div>

        </div>

    </div>


    {{-- ============================================================
         GENERATED REPORTS
         
         The chart section was removed.
    ============================================================ --}}
    <div class="pd-card rp-reports-card">

        <div class="rp-section-header">

            <div>
                <h2 class="pd-card__title pd-card__title--no-icon">
                    Generated reports
                </h2>

                <p class="pd-card__subtitle">
                    Previously generated report exports
                </p>
            </div>

        </div>


        {{-- ========================================================
             TABLE
        ========================================================= --}}
        <div class="rp-table-wrapper">

            <table class="rp-table">

                <thead>
                    <tr>
                        <th>Report name</th>
                        <th>Type</th>
                        <th>Date range</th>
                        <th>Generated by</th>
                        <th>Generated on</th>
                        <th>Status</th>
                        <th class="rp-table__actions-header">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($reports ?? [] as $report)

                        @php
                            $reportId = data_get($report, 'id');
                            $reportName = data_get($report, 'name', 'Untitled report');
                            $reportType = data_get($report, 'type', '—');
                            $dateFrom = data_get($report, 'date_from');
                            $dateTo = data_get($report, 'date_to');
                            $generatedBy = data_get($report, 'generated_by', '—');
                            $createdAt = data_get($report, 'created_at');
                            $status = data_get($report, 'status', 'pending');
                        @endphp

                        <tr>

                            {{-- Report name --}}
                            <td>
                                <span class="rp-report-name">
                                    {{ $reportName }}
                                </span>
                            </td>


                            {{-- Type --}}
                            <td>
                                {{ $reportType }}
                            </td>


                            {{-- Date range --}}
                            <td>

                                @if($dateFrom || $dateTo)

                                    {{ $dateFrom ?: '—' }}
                                    <span class="rp-date-separator">—</span>
                                    {{ $dateTo ?: '—' }}

                                @else

                                    —

                                @endif

                            </td>


                            {{-- Generated by --}}
                            <td>
                                {{ $generatedBy }}
                            </td>


                            {{-- Generated on --}}
                            <td>

                                @if($createdAt)

                                    {{ $createdAt }}

                                @else

                                    —

                                @endif

                            </td>


                            {{-- Status --}}
                            <td>

                                @php
                                    $safeStatus = strtolower((string) $status);

                                    $allowedStatuses = [
                                        'completed',
                                        'pending',
                                        'failed'
                                    ];

                                    if (!in_array($safeStatus, $allowedStatuses)) {
                                        $safeStatus = 'pending';
                                    }
                                @endphp

                                <span class="rp-badge rp-badge--{{ $safeStatus }}">
                                    {{ ucfirst($status) }}
                                </span>

                            </td>


                            {{-- Actions --}}
                            {{-- EYE BUTTON REMOVED --}}
                            <td class="rp-table__actions">

                                @if($reportId)

                                    <a
                                        href="{{ route('reports.download', $reportId) }}"
                                        class="rp-download-btn">
                                        Download
                                    </a>

                                @else

                                    <span class="rp-no-action">
                                        —
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="rp-table__empty">

                                No reports have been generated yet.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const applyBtn = document.querySelector('.rp-filters__actions .pd-btn--primary');
    const resetBtn = document.querySelector('.rp-filters__actions .pd-btn--outline');
    const exportBtn = document.getElementById('rp-export-btn');

    function buildQuery() {
        const params = new URLSearchParams();
        const dateFrom = document.getElementById('rp-date-from').value;
        const dateTo = document.getElementById('rp-date-to').value;
        const doctor = document.getElementById('rp-doctor').value;

        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);
        if (doctor) params.append('doctor', doctor);

        return params.toString();
    }

    // Export button → downloads CSV for the selected report type
    exportBtn.addEventListener('click', function () {
        const type = document.getElementById('rp-report-type').value || 'patients';
        const query = buildQuery();
        const url = `/reports/export/${type}` + (query ? `?${query}` : '');
        window.location.href = url;
    });

    // Apply filters → reloads the page with filters as query params
    applyBtn.addEventListener('click', function () {
        const query = buildQuery();
        window.location.href = `{{ route('reports.index') }}` + (query ? `?${query}` : '');
    });

    // Reset → clears filters
    resetBtn.addEventListener('click', function () {
        window.location.href = `{{ route('reports.index') }}`;
    });
});
</script>
@endpush
@endsection