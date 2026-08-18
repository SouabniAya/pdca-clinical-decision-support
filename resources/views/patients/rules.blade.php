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
        <a href="#" class="crr-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            Add Rule
        </a>
    </div>

    <div class="crr-stats">

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="3" width="12" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Total Clinical Rules</h3>
                <strong>11</strong>
            </div>
        </div>

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h11M4 12h11M4 18h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M17 5.5l1.3 1.3L21 4M17 11.5l1.3 1.3L21 10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Active Rules</h3>
                <strong>11</strong>
            </div>
        </div>

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="6" cy="6" r="2.2" stroke="currentColor" stroke-width="1.5"/><circle cx="18" cy="6" r="2.2" stroke="currentColor" stroke-width="1.5"/><circle cx="6" cy="18" r="2.2" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="2.2" stroke="currentColor" stroke-width="1.5"/><path d="M8 7l3 3M16 7l-3 3M8 17l3-3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Clinical Criteria</h3>
                <strong>5</strong>
            </div>
        </div>

        <div class="crr-stat-card">
            <span class="crr-stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 15l6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M11 6l1.3-1.3a3 3 0 0 1 4.2 4.2L15 10M13 18l-1.3 1.3a3 3 0 0 1-4.2-4.2L9 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="crr-stat-card__body">
                <h3>Clinical Sources</h3>
                <strong>3</strong>
            </div>
        </div>

    </div>

    <div class="crr-toolbar">
        <div class="crr-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" placeholder="Search rules...">
        </div>

        <div class="crr-toolbar__filter">
            <span>Status</span>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>

        <button type="button" class="crr-toolbar__reset">
            Reset
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </div>

    <div class="crr-table-wrap">
        <table class="crr-table">
            <thead>
                <tr>
                    <th>Rule ID</th>
                    <th>Clinical Criteria</th>
                    <th>Conditions</th>
                    <th>Recommendation</th>
                    <th>Source</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>R1</td>
                    <td><a href="#" class="crr-table__criteria">Resectable — Type A</a></td>
                    <td>PS 0-1, no surgical contraindication</td>
                    <td>Curative surgery &rarr; adjuvant chemotherapy for 6 months (mFOLFIRINOX)</td>
                    <td>TNCD &sect;9.5.1</td>
                    <td>
                        <div class="crr-table__actions">
                            <button type="button" class="crr-table__edit" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20h4l11-11-4-4L4 16v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" aria-label="More options">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>R1</td>
                    <td><a href="#" class="crr-table__criteria">Resectable — Type A</a></td>
                    <td>PS 0-1, no surgical contraindication</td>
                    <td>Curative surgery &rarr; adjuvant chemotherapy for 6 months (mFOLFIRINOX)</td>
                    <td>TNCD &sect;9.5.1</td>
                    <td>
                        <div class="crr-table__actions">
                            <button type="button" class="crr-table__edit" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20h4l11-11-4-4L4 16v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" aria-label="More options">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>R1</td>
                    <td><a href="#" class="crr-table__criteria">Resectable — Type A</a></td>
                    <td>PS 0-1, no surgical contraindication</td>
                    <td>Curative surgery &rarr; adjuvant chemotherapy for 6 months (mFOLFIRINOX)</td>
                    <td>TNCD &sect;9.5.1</td>
                    <td>
                        <div class="crr-table__actions">
                            <button type="button" class="crr-table__edit" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20h4l11-11-4-4L4 16v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" aria-label="More options">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>R1</td>
                    <td><a href="#" class="crr-table__criteria">Resectable — Type A</a></td>
                    <td>PS 0-1, no surgical contraindication</td>
                    <td>Curative surgery &rarr; adjuvant chemotherapy for 6 months (mFOLFIRINOX)</td>
                    <td>TNCD &sect;9.5.1</td>
                    <td>
                        <div class="crr-table__actions">
                            <button type="button" class="crr-table__edit" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20h4l11-11-4-4L4 16v4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" aria-label="More options">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="#" class="crr-page__view-all">View All Rules &rarr;</a>

</div>
@endsection
