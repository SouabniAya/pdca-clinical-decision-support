<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\RcpMeeting;
use Illuminate\Http\Request;

class RcpController extends Controller
{
    /**
     * Show the "complete the RCP sheet" form for a recommendation
     * that has been sent to RCP.
     */
    public function create($recommendationId)
    {
        $rec = Recommendation::with('consultation.patient')->findOrFail($recommendationId);

        abort_unless($rec->status === Recommendation::STATUS_RCP, 409,
            'This recommendation has not been sent to RCP.');

        if ($rec->rcpMeeting) {
            return redirect()->route('rcp.show', $rec->recommendation_id);
        }

        return view('rcp.form', ['rec' => $rec, 'meeting' => null]);
    }

    public function store(Request $request, $recommendationId)
    {
        $rec = Recommendation::findOrFail($recommendationId);

        $data = $request->validate([
            'meeting_date' => 'required|date',
            'participants' => 'required|string',
            'final_decision' => 'required|string',
            'deviates_from_recommendation' => 'nullable|boolean',
            'deviation_reason' => 'required_if:deviates_from_recommendation,1|nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data['deviates_from_recommendation'] = $request->boolean('deviates_from_recommendation');
        $data['recommendation_id'] = $rec->recommendation_id;

        RcpMeeting::updateOrCreate(
            ['recommendation_id' => $rec->recommendation_id],
            $data
        );

        return redirect()
            ->route('rcp.show', $rec->recommendation_id)
            ->with('success', 'RCP sheet saved.');
    }

    /**
     * View the completed RCP sheet, alongside the original engine
     * recommendation, so the deviation (if any) is visible side by side.
     */
    public function show($recommendationId)
    {
        $rec = Recommendation::with(['consultation.patient', 'rcpMeeting'])
            ->findOrFail($recommendationId);

        abort_unless($rec->rcpMeeting, 404, 'No RCP sheet has been completed for this recommendation yet.');

        return view('rcp.show', [
            'rec' => $rec,
            'meeting' => $rec->rcpMeeting,
        ]);
    }
}
