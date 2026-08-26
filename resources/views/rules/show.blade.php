@extends('layouts.app')

@section('title', 'Rule ' . $rule->rule_id)

@php($active = 'rules')

@section('content')
<div class="pd-page">

    <div class="pd-card pd-header">
        <div class="pd-header__left">
            <span class="pd-header__avatar"></span>
            <div>
                <h1>{{ $rule->rule_id }} — {{ $rule->title }}</h1>
                <div class="pd-header__meta">
                    <span class="pd-header__id">{{ $rule->category_label }}</span>
                    @if ($rule->active)
                        <span class="crr-badge crr-badge--active">Active</span>
                    @else
                        <span class="crr-badge crr-badge--inactive">Inactive</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="pd-header__right">
            <a href="{{ route('rules.edit', $rule->clinical_rule_id) }}" class="pd-btn pd-btn--outline pd-btn--sm">Edit Rule</a>
        </div>
    </div>

    <div class="pd-main" style="max-width:960px; margin:0 auto; width:100%;">

        <div class="pd-card">
            <h2 class="pd-card__title pd-card__title--no-icon">Conditions</h2>
            <p class="pd-card__subtitle">The clinical situation under which this rule applies.</p>
            <p>{{ $rule->conditions }}</p>
        </div>

        <div class="pd-card">
            <h2 class="pd-card__title pd-card__title--no-icon">Recommendation</h2>
            <p>{{ $rule->recommendation }}</p>
        </div>

        <div class="pd-card">
            <h2 class="pd-card__title pd-card__title--no-icon">Justification</h2>
            <p>{{ $rule->justification }}</p>
        </div>

        <div class="pd-card">
            <div class="pd-justification">
                <span>Source</span>
                <strong>{{ $rule->source ?? '—' }}</strong>
            </div>
            <div class="pd-justification">
                <span>Evidence grade</span>
                <strong>{{ $rule->grade ?? '—' }}</strong>
            </div>
        </div>

    </div>

    <div class="pd-action-bar" style="max-width:960px; margin:0 auto; width:100%; grid-template-columns:1fr 1fr;">
        <a href="{{ route('rules.index') }}" class="pd-btn pd-btn--outline">Back to Repository</a>
        <a href="{{ route('rules.edit', $rule->clinical_rule_id) }}" class="pd-btn pd-btn--primary">Edit This Rule</a>
    </div>

</div>
@endsection
