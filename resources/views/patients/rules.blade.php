@extends('layouts.app')

@section('title', 'Clinical Rules Repository')

@php($active = 'rules')

@section('content')
<div class="crr-page">

    <div class="crr-page__head">
        <div>
            <h1>Clinical Rules Repository</h1>
            <p>Browse and manage the clinical rules used by the PDAC decision engine.</p>
        </div>
        <a href="{{ route('rules.create') }}" class="crr-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            Add Rule
        </a>
    </div>

    @if (session('success'))
        <div class="crr-alert crr-alert--success">{{ session('success') }}</div>
    @endif

    <div class="crr-stats">

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="3" width="12" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Total Clinical Rules</h3>
                <strong>{{ $totalCount }}</strong>
            </div>
        </div>

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h11M4 12h11M4 18h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M17 5.5l1.3 1.3L21 4M17 11.5l1.3 1.3L21 10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Active Rules</h3>
                <strong>{{ $activeCount }}</strong>
            </div>
        </div>

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="6" cy="6" r="2.2" stroke="currentColor" stroke-width="1.5"/><circle cx="18" cy="6" r="2.2" stroke="currentColor" stroke-width="1.5"/><circle cx="6" cy="18" r="2.2" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="2.2" stroke="currentColor" stroke-width="1.5"/><path d="M8 7l3 3M16 7l-3 3M8 17l3-3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Clinical Categories</h3>
                <strong>{{ $categoryCount }}</strong>
            </div>
        </div>

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 15l6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M11 6l1.3-1.3a3 3 0 0 1 4.2 4.2L15 10M13 18l-1.3 1.3a3 3 0 0 1-4.2-4.2L9 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Clinical Sources</h3>
                <strong>{{ $sourceCount }}</strong>
            </div>
        </div>

    </div>

    <form method="GET" action="{{ route('rules.index') }}" class="crr-toolbar">
        <div class="crr-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search rules...">
        </div>

        <label class="crr-toolbar__filter">
            <select name="status" onchange="this.form.submit()" style="border:0;background:transparent;font:inherit;">
                <option value="">All statuses</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
        </label>

        <button type="submit" class="crr-toolbar__reset" style="margin-right:8px;">Search</button>
        <a href="{{ route('rules.index') }}" class="crr-toolbar__reset">
            Reset
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </form>

    <div class="crr-table-wrap">
        <table class="crr-table">
            <thead>
                <tr>
                    <th>Rule ID</th>
                    <th>Title</th>
                    <th>Conditions</th>
                    <th>Recommendation</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rules as $rule)
                <tr>
                    <td><strong>{{ $rule->rule_id }}</strong></td>
                    <td><a href="{{ route('rules.show', $rule->clinical_rule_id) }}" class="crr-table__criteria">{{ $rule->title }}</a></td>
                    <td>{{ \Illuminate\Support\Str::limit($rule->conditions, 90) }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($rule->recommendation, 90) }}</td>
                    <td>{{ $rule->source ?? '—' }}</td>
                    <td>
                        @if ($rule->active)
                            <span class="crr-badge crr-badge--active">Active</span>
                        @else
                            <span class="crr-badge crr-badge--inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="crr-table__actions">
                            <a href="{{ route('rules.edit', $rule->clinical_rule_id) }}" class="crr-table__edit" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20h4l11-11-4-4L4 16v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </a>
                            <form method="POST" action="{{ route('rules.destroy', $rule->clinical_rule_id) }}" onsubmit="return confirm('Delete rule {{ $rule->rule_id }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" aria-label="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 7h16M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2m-8 0 1 13a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2l1-13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:var(--color-neutral-500); padding:32px;">
                        No clinical rules found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
