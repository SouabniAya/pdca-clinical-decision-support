@extends('layouts.app')

@section('title', $rule ? 'Edit Rule' : 'Add Rule')

@php($active = 'rules')

@section('content')
<div class="patients-page">

    <div class="patients-page__head">
        <div>
            <h1>{{ $rule ? 'Edit Clinical Rule' : 'Add Clinical Rule' }}</h1>
            <p>{{ $rule ? 'Update the content of rule ' . $rule->rule_id . '.' : 'Add a new rule to the clinical decision repository.' }}</p>
        </div>
        <a href="{{ route('rules.index') }}" class="patients-page__btn patients-page__btn--ghost">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to Repository
        </a>
    </div>

    <form
        class="clinical-form"
        method="POST"
        action="{{ $rule ? route('rules.update', $rule->clinical_rule_id) : route('rules.store') }}"
    >
        @csrf
        @if ($rule)
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="clinical-form__error">{{ $errors->first() }}</div>
        @endif

        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="3" width="12" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M9 3h6v3H9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                <h2>Identification</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field">
                    <label for="rule_id">Rule ID</label>
                    <input type="text" id="rule_id" name="rule_id" placeholder="e.g. R13" value="{{ old('rule_id', $rule->rule_id ?? '') }}" required>
                </div>

                <div class="clinical-form__field">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g. Resectable — Type A" value="{{ old('title', $rule->title ?? '') }}" required>
                </div>

                <div class="clinical-form__field">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">Select...</option>
                        @foreach ($categories as $key => $label)
                            <option value="{{ $key }}" @selected(old('category', $rule->category ?? '') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="clinical-form__field clinical-form__field--checkbox">
                    <label class="clinical-form__checkbox">
                        <input type="checkbox" name="active" value="1" @checked(old('active', $rule->active ?? true))>
                        Active (used by the rule engine)
                    </label>
                </div>
            </div>
        </div>

        <div class="clinical-form__section">
            <div class="clinical-form__section-head">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <h2>Clinical Content</h2>
            </div>
            <div class="clinical-form__grid">
                <div class="clinical-form__field clinical-form__field--full">
                    <label for="conditions">Conditions</label>
                    <textarea id="conditions" name="conditions" rows="3" placeholder="The clinical situation under which this rule applies..." required>{{ old('conditions', $rule->conditions ?? '') }}</textarea>
                </div>

                <div class="clinical-form__field clinical-form__field--full">
                    <label for="recommendation">Recommendation</label>
                    <textarea id="recommendation" name="recommendation" rows="3" placeholder="The recommended course of action..." required>{{ old('recommendation', $rule->recommendation ?? '') }}</textarea>
                </div>

                <div class="clinical-form__field clinical-form__field--full">
                    <label for="justification">Justification</label>
                    <textarea id="justification" name="justification" rows="3" placeholder="Why this recommendation applies..." required>{{ old('justification', $rule->justification ?? '') }}</textarea>
                </div>

                <div class="clinical-form__field">
                    <label for="source">Source</label>
                    <input type="text" id="source" name="source" placeholder="e.g. TNCD §9.5.1" value="{{ old('source', $rule->source ?? '') }}">
                </div>

                <div class="clinical-form__field">
                    <label for="grade">Evidence grade</label>
                    <input type="text" id="grade" name="grade" placeholder="e.g. A, B, Expert consensus" value="{{ old('grade', $rule->grade ?? '') }}">
                </div>
            </div>
        </div>

        <div class="clinical-form__actions">
            <a href="{{ route('rules.index') }}" class="clinical-form__cancel">Cancel</a>
            <button type="submit" class="clinical-form__submit">{{ $rule ? 'Save Changes' : 'Create Rule' }}</button>
        </div>
    </form>

</div>
@endsection
