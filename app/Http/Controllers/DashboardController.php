<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Patient;
use App\Models\Recommendation;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Patient::count(),
            'active' => Patient::where('status', 'active')->count(),
            'pending_recommendations' => Recommendation::where('status', Recommendation::STATUS_PROPOSED)->count(),
            'new_this_month' => Patient::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
        ];

        $statusBreakdown = $this->patientsByStatus($stats['total']);

        $pendingRecommendations = Recommendation::with('consultation.patient')
            ->where('status', Recommendation::STATUS_PROPOSED)
            ->orderByDesc('generation_date')
            ->take(4)
            ->get()
            ->map(function (Recommendation $rec) {
                $patient = $rec->consultation->patient;

                return [
                    'id' => $rec->recommendation_id,
                    'patient_id' => $patient->patient_id,
                    'patient_name' => trim($patient->first_name . ' ' . $patient->last_name),
                    'recommendation_text' => $rec->recommendation_text,
                    'stage' => $rec->consultation->clinical_stage,
                ];
            });

        $recentActivity = ActivityLog::orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('patients.dashboard', [
            'stats' => $stats,
            'statusBreakdown' => $statusBreakdown,
            'pendingRecommendations' => $pendingRecommendations,
            'recentActivity' => $recentActivity,
        ]);
    }

    /**
     * Active / Inactive split for the donut chart, as percentages that
     * already sum to (at most) 100, plus the raw SVG dash values so the
     * blade doesn't need to do circle-geometry math.
     *
     * Only 'active' and 'inactive' exist on `patient.status` (see the
     * add_status_to_patient migration) — there is no "archived" state
     * in the schema, so the old hard-coded 3rd legend entry is dropped.
     */
    private function patientsByStatus(int $total): array
    {
        $active = Patient::where('status', 'active')->count();
        $inactive = Patient::where('status', 'inactive')->count();

        $circumference = 2 * M_PI * 70; // r=70, matches the SVG in the blade

        $activePct = $total > 0 ? round(($active / $total) * 100) : 0;
        $inactivePct = $total > 0 ? round(($inactive / $total) * 100) : 0;

        $activeDash = $total > 0 ? ($active / $total) * $circumference : 0;
        $inactiveDash = $total > 0 ? ($inactive / $total) * $circumference : 0;

        return [
            'total' => $total,
            'active' => ['count' => $active, 'pct' => $activePct, 'dasharray' => round($activeDash, 2)],
            'inactive' => ['count' => $inactive, 'pct' => $inactivePct, 'dasharray' => round($inactiveDash, 2)],
            'circumference' => round($circumference, 2),
        ];
    }
}