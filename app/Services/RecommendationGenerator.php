<?php

namespace App\Services;

use App\Models\Consultation;
use App\Models\Recommendation;

/**
 * Bridges the database layer (Consultation + TumorEvaluation +
 * comorbidities) and the framework-agnostic PdacRuleEngine, then
 * persists the traceable result as a Recommendation row.
 *
 * This is what actually implements RF-11 ("the system automatically
 * generates a recommendation once clinical data is entered") and
 * RF-12 ("every recommendation is accompanied by its justification").
 */
class RecommendationGenerator
{
    /**
     * Build the rule-engine input array from a Consultation and run it.
     *
     * @return array The raw PdacRuleEngine::evaluate() result.
     */
    public static function evaluate(Consultation $consultation): array
    {
        $evaluation = $consultation->tumorEvaluation;

        abort_if(! $evaluation, 422, 'This consultation has no clinical evaluation to generate a recommendation from.');

        $hasSevereComorbidity = $consultation->comorbidities()
            ->wherePivot('severity', 'severe')
            ->exists();

        // Bilirubin is not currently captured as a discrete field on the
        // clinical form; treated as "not elevated" until the form exposes it.
        $bilirubinElevated = false;

        $patient = $consultation->patient;

        $data = [
            'resectability' => $evaluation->resectability,
            'performance_status' => (int) $consultation->performance_status,
            'ca19_9' => (float) ($evaluation->ca19_9_level ?? 0),
            'cholestasis' => (bool) $evaluation->cholestasis,
            'surgical_contraindication' => (bool) $evaluation->surgery_contraindication,
            'severe_comorbidities' => $hasSevereComorbidity,
            'bilirubin_elevated' => $bilirubinElevated,
            'age' => $patient?->age ?? 0,
            // Not yet captured on the clinical form — default to false
            // until a BRCA / platinum-response field is added (R12 overlay).
            'brca_mutation' => false,
            'stable_16w_on_platinum' => false,
        ];

        return PdacRuleEngine::evaluate($data);
    }

    /**
     * Evaluate the consultation and persist the result as a new
     * Recommendation row (each new clinical evaluation produces its
     * own recommendation, so history is preserved).
     */
    public static function generateAndStore(Consultation $consultation): Recommendation
    {
        $result = self::evaluate($consultation);

        return Recommendation::create([
            'consultation_id' => $consultation->consultation_id,
            'recommendation_type' => $result['rule_id'],
            'generation_date' => now(),
            'status' => Recommendation::STATUS_PROPOSED,
            'rule_id' => $result['rule_id'],
            'recommendation_text' => $result['recommendation'],
            'justification' => $result['justification'],
            'source' => $result['source'],
            'grade' => $result['grade'],
            'abc_type' => $result['abc_type'],
            'conflict' => $result['conflict'],
            'conflict_reason' => $result['conflict_reason'],
            'details' => [
                'transversal_note' => $result['transversal_note'] ?? null,
                'overlay_rule' => $result['overlay_rule'] ?? null,
            ],
        ]);
    }
}
