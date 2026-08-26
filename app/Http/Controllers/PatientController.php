<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Patient;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('latestConsultation');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('medical_record_number', 'like', "%$search%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($stage = $request->input('stage')) {
            $query->whereHas('latestConsultation', fn ($q) => $q->where('clinical_stage', $stage));
        }

        $patients = $query->orderBy('last_name')->paginate(10)->withQueryString();

        $stats = [
            'total' => Patient::count(),
            'active' => Patient::where('status', 'active')->count(),
            'new_this_month' => Patient::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
            'pending_recommendations' => Recommendation::where('status', 'proposed')->count(),
        ];

        return view('patients.list', compact('patients', 'stats'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:M,F',
            'medical_record_number' => 'required|string|max:50|unique:patient,medical_record_number',
        ]);

        $data['created_at'] = now();

        $patient = Patient::create($data);

        ActivityLog::log(
            ActivityLog::TYPE_PATIENT_CREATED,
            'New patient <strong>' . e(trim($patient->first_name . ' ' . $patient->last_name)) . '</strong> was registered',
            null,
            $patient->patient_id
        );

        return redirect()->route('patients.index')->with('success', 'Patient ajouté.');
    }

public function show($id)
{
    $patient = Patient::with('consultations.doctor')->findOrFail($id);
    $latest = $patient->consultations->sortByDesc('consultation_date')->first();

    return view('patients.details', compact('patient', 'latest'));
}

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }
public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:M,F',
            'status' => 'required|in:active,inactive',
            'medical_record_number' => 'required|string|max:50|unique:patient,medical_record_number,' . $id . ',patient_id',
        ]);

        $previousStatus = $patient->status;
        $name = e(trim($patient->first_name . ' ' . $patient->last_name));

        $patient->update($data);

        if ($previousStatus !== $data['status']) {
            ActivityLog::log(
                ActivityLog::TYPE_STATUS_CHANGED,
                "<strong>{$name}</strong>'s status changed to " . ucfirst($data['status']),
                'Previously ' . ucfirst($previousStatus),
                $patient->patient_id
            );
        } else {
            ActivityLog::log(
                ActivityLog::TYPE_PATIENT_UPDATED,
                "<strong>{$name}</strong>'s record was updated",
                null,
                $patient->patient_id
            );
        }

        return redirect()->route('patients.index')->with('success', 'Patient mis à jour.');
    }
public function details(Patient $patient)
{
    return view('patients.details', compact('patient'));
}
    public function destroy($id)
    {
        Patient::findOrFail($id)->delete();
        return redirect()->route('patients.index')->with('success', 'Patient supprimé.');
    }
}