@extends('layouts.app')

@section('title', 'Patient List')

@php($active = 'patients')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>Patient List</h1>
            <p>View and manage patients registered in the system.</p>
        </div>
        <a href="{{ route('patients.create') }}" class="patients-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            New Patient
        </a>
    </div>

    @if (session('success'))
        <div style="margin-bottom:16px;padding:12px 16px;background:#e6f7ec;color:#1a7f3c;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="patients-stats">

        <div class="patient-stat-card">
            <span class="patient-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M2.5 19c0-3 2.9-4.7 6.5-4.7s6.5 1.7 6.5 4.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="16.5" cy="8.3" r="2.4" stroke="currentColor" stroke-width="1.6"/><path d="M14.6 19c.3-2.3 2.1-3.7 4.4-3.7s4.1 1.4 4.4 3.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="patient-stat-card__body">
                <h3>Registered Patients</h3>
                <strong>{{ $stats['total'] }}</strong>
                <span>Total patients</span>
            </div>
        </div>

        <div class="patient-stat-card">
            <span class="patient-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="patient-stat-card__body">
                <h3>Recommendations</h3>
                <strong>{{ $stats['pending_recommendations'] }}</strong>
                <span>Awaiting review</span>
            </div>
        </div>

        <div class="patient-stat-card">
            <span class="patient-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="patient-stat-card__body">
                <h3>Active Patients</h3>
                <strong>{{ $stats['active'] }}</strong>
                <span>Currently active</span>
            </div>
        </div>

        <div class="patient-stat-card">
            <span class="patient-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="patient-stat-card__body">
                <h3>New Patients</h3>
                <strong>{{ $stats['new_this_month'] }}</strong>
                <span>This month</span>
            </div>
        </div>

    </div>

    <form method="GET" action="{{ route('patients.index') }}" class="patients-toolbar">
        <div class="patients-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search patient by name or ID...">
        </div>

        <select name="status" class="patients-toolbar__filter" onchange="this.form.submit()">
            <option value="">Status</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
        </select>

        <select name="stage" class="patients-toolbar__filter" onchange="this.form.submit()">
            <option value="">Stage</option>
            @foreach (['I', 'II', 'III', 'IV'] as $stageOption)
                <option value="{{ $stageOption }}" @selected(request('stage') === $stageOption)>{{ $stageOption }}</option>
            @endforeach
        </select>

        <a href="{{ route('patients.index') }}" class="patients-toolbar__reset">
            Reset
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </form>

    <div class="patients-table-wrap">
        <table class="patients-table">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Stage</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patient)
                <tr>
                    <td>P{{ str_pad($patient->patient_id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->age }}</td>
                    <td><span class="patients-table__status">{{ ucfirst($patient->status) }}</span></td>
                    <td>{{ $patient->latestConsultation->clinical_stage ?? '—' }}</td>
                    <td>{{ optional($patient->latestConsultation->consultation_date ?? null)->format('d/m/Y') ?? '—' }}</td>
                    <td>
                        <div class="patients-table__actions" style="position:relative;">
                            <a href="{{ route('patients.show', $patient->patient_id) }}" aria-label="View">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="More options" onclick="togglePatientMenu(event, '{{ $patient->patient_id }}')">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>

                            <div class="patient-actions-menu" id="menu-{{ $patient->patient_id }}" style="display:none;position:absolute;right:0;top:calc(100% + 4px);background:#fff;border:1px solid #e2e2e2;border-radius:8px;box-shadow:0 6px 16px rgba(0,0,0,.1);z-index:20;min-width:130px;overflow:hidden;">
                                <a href="{{ route('patients.edit', $patient->patient_id) }}" style="display:block;padding:10px 14px;color:#1a1a1a;text-decoration:none;font-size:14px;">Edit</a>
                                <form method="POST" action="{{ route('patients.destroy', $patient->patient_id) }}" onsubmit="return confirm('Delete this patient? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="display:block;width:100%;text-align:left;padding:10px 14px;background:none;border:0;border-top:1px solid #f0f0f0;color:#c0392b;font-size:14px;cursor:pointer;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">No patients found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;">
        {{ $patients->links() }}
    </div>

</div>

<script>
    function togglePatientMenu(event, id) {
        event.stopPropagation();
        document.querySelectorAll('.patient-actions-menu').forEach(function (menu) {
            if (menu.id !== 'menu-' + id) menu.style.display = 'none';
        });
        var menu = document.getElementById('menu-' + id);
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
    document.addEventListener('click', function () {
        document.querySelectorAll('.patient-actions-menu').forEach(function (menu) {
            menu.style.display = 'none';
        });
    });
</script>
@endsection