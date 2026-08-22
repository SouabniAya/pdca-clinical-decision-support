@extends('layouts.app')
 
@section('title', 'Edit Patient')
 
@php($active = 'patients')
 
@section('content')
<div class="patients-page">
 
    <div class="patients-page__head">
        <div>
            <h1>Edit Patient</h1>
            <p>Update this patient's information.</p>
        </div>
        <a href="{{ route('patients.show', $patient->patient_id) }}" class="patients-page__btn" style="background:#fff;color:#111;border:1px solid #e2e2e2;">
            &larr; Back to Patient
        </a>
    </div>
 
    @if ($errors->any())
        <div style="margin-bottom:16px;padding:12px 16px;background:#fdecea;color:#b3261e;border-radius:8px;">
            {{ $errors->first() }}
        </div>
    @endif
 
    <div class="patients-table-wrap" style="padding:24px;">
        <form method="POST" action="{{ route('patients.update', $patient->patient_id) }}">
            @csrf
            @method('PUT')
 
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:22px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Sex</label>
                    <select name="sex" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                        <option value="M" @selected(old('sex', $patient->sex) === 'M')>Male</option>
                        <option value="F" @selected(old('sex', $patient->sex) === 'F')>Female</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Status</label>
                    <select name="status" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                        <option value="active" @selected(old('status', $patient->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $patient->status) === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Medical Record Number</label>
                    <input type="text" name="medical_record_number" value="{{ old('medical_record_number', $patient->medical_record_number) }}" style="width:100%;padding:10px 12px;border:1px solid #e2e2e2;border-radius:8px;font-size:14px;">
                </div>
            </div>
 
            <button type="submit" class="patients-page__btn">
                Save Changes
            </button>
        </form>
    </div>
 
</div>
@endsection
 