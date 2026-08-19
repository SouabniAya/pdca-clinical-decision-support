<?php

namespace App\Services;

/**
 * PDAC Clinical Rule Engine
 *
 * Implements the decision table (R1–R12) and the ABC stratification
 * criteria from the Week 1 deliverable (TNCD Chapter 9, §9.2.5 and §9.5).
 *
 * Kept as an isolated, framework-agnostic service (no dependency on the
 * HTTP layer) so it stays testable in isolation, per RNF-09.
 *
 * This is NOT a machine-learning model: every output is traceable to an
 * explicit rule ID, its source, and its justification (RNF-01, RNF-06).
 */
class PdacRuleEngine
{
    /**
     * @param array{
     *   resectability: string,      // 'resectable' | 'borderline' | 'locally_advanced' | 'metastatic'
     *   performance_status: int,    // ECOG / OMS, 0–4
     *   ca19_9: float,              // U/mL
     *   cholestasis: bool,          // presence of cholestasis (invalidates CA19-9 criterion)
     *   surgical_contraindication: bool,
     *   severe_comorbidities: bool,
     *   bilirubin_elevated: bool,   // >= 1.5x ULN
     *   age: int,
     *   brca_mutation: bool,
     *   stable_16w_on_platinum: bool,
     * } $data
     *
     * @return array{
     *   rule_id: string,
     *   recommendation: string,
     *   justification: string,
     *   source: string,
     *   grade: string,
     *   abc_type: ?string,
     *   conflict: bool,
     *   conflict_reason: ?string,
     *   overlay_rule: ?array,
     * }
     */
    public static function evaluate(array $data): array
    {
        $ps = $data['performance_status'] ?? 0;
        $ca199 = $data['ca19_9'] ?? 0.0;
        $cholestasis = $data['cholestasis'] ?? false;
        $result = null;

        $abcType = null;

        switch ($data['resectability']) {

            case 'resectable':
                $abcType = self::classifyAbc($ca199, $cholestasis, $ps);

                // R3 — resectable but not operable (severe comorbidities / surgical CI)
                if (($data['surgical_contraindication'] ?? false) || ($data['severe_comorbidities'] ?? false)) {
                    $result = self::rule('R3',
                        'Manage as locally advanced',
                        'Anatomically resectable tumor, but the patient is not a surgical candidate (severe comorbidities and/or surgical contraindication). The case is managed following the locally advanced pathway.',
                        '9.5.1 OPTIONS', 'Options');
                    break;
                }

                // Conflict zone: CA19-9 near the 500 U/mL threshold — R1 vs R2 ambiguity (§2.4)
                if (!$cholestasis && $ca199 >= 450 && $ca199 <= 550) {
                    $result = self::rule('RCP',
                        'Refer to multidisciplinary team meeting (RCP)',
                        'CA19-9 is at the borderline of the 500 U/mL threshold, so Type A vs Type AB classification is ambiguous. Per the rule-conflict policy (§2.4), the system does not decide silently and instead proposes a multidisciplinary review.',
                        '§2.4 — Rule conflict management', 'N/A');
                    $result['conflict'] = true;
                    $result['conflict_reason'] = 'R1 (Type A → curative surgery) and R2 (Type AB → neoadjuvant chemotherapy) could both apply — CA19-9 is within ±50 U/mL of the 500 U/mL threshold.';
                    break;
                }

                if ($abcType === 'A') {
                    $result = self::rule('R1',
                        'Curative surgery (DPC or SPG) → adjuvant chemotherapy 6 months (mFOLFIRINOX)',
                        'Resectable tumor, Type A (no adverse biological or clinical factor), ECOG 0–1, no surgical contraindication.',
                        '9.5.1 REFERENCES', 'A');
                } else {
                    $result = self::rule('R2',
                        'Neoadjuvant chemotherapy to discuss (option)',
                        "Resectable tumor but Type {$abcType} (CA19-9 > 500 U/mL and/or ECOG ≥ 1), reclassifying the tumor as at higher risk despite favorable anatomy — neoadjuvant chemotherapy should be discussed.",
                        '9.5.1 OPTIONS', 'Expert opinion');
                }
                break;

            case 'borderline':
                $result = self::rule('R4',
                    'Systematic mFOLFIRINOX induction chemotherapy — no upfront surgery',
                    'Borderline resectable tumor, regardless of performance status. Upfront surgery is not indicated.',
                    '9.5.2 REFERENCES', 'B');
                break;

            case 'locally_advanced':
                if ($ps <= 1) {
                    $result = self::rule('R5',
                        'mFOLFIRINOX induction chemotherapy; reassess resectability at every follow-up',
                        'Locally advanced tumor, ECOG 0–1. Resectability should be reassessed at each control to allow secondary surgery if downstaging occurs.',
                        '9.5.3 REFERENCES', 'A');
                } elseif ($ps === 2) {
                    $result = self::rule('R6', 'Gemcitabine alone',
                        'Locally advanced tumor, ECOG 2.', '9.5.3 REFERENCES', 'A');
                } else {
                    $result = self::rule('R7', 'Best supportive care only',
                        'Locally advanced tumor, ECOG 3–4.', '9.5.3 REFERENCES', 'Expert consensus');
                }
                break;

            case 'metastatic':
                $bili = $data['bilirubin_elevated'] ?? false;
                $age = $data['age'] ?? 0;

                if ($ps <= 1 && $age < 75 && !$bili) {
                    $result = self::rule('R8',
                        'FOLFIRINOX / mFOLFIRINOX or gemcitabine + nab-paclitaxel',
                        'Metastatic disease, ECOG 0–1, age < 75, bilirubin < 1.5x ULN.',
                        '9.5.4.1', 'A (gem + nab-paclitaxel not reimbursed)');
                } elseif ($ps === 2 && !$bili) {
                    $result = self::rule('R9', 'Gemcitabine alone',
                        'Metastatic disease, ECOG 2, bilirubin < 1.5x ULN.', '9.5.4.1', 'A');
                } elseif ($ps <= 2 && ($bili || ($data['severe_comorbidities'] ?? false))) {
                    $result = self::rule('R10', 'Gemcitabine alone',
                        'Metastatic disease, ECOG 0–2, with elevated bilirubin (≥ 1.5x ULN) and/or significant comorbidities.',
                        '9.5.4.1', 'A');
                } else {
                    $result = self::rule('R11', 'Best supportive care only',
                        'Metastatic disease, ECOG 3–4.', '9.5.4.1', 'Expert consensus');
                }
                break;

            default:
                $result = self::rule('N/A', 'No matching rule',
                    'No rule in the decision table matches the provided clinical data. Per RNF-06, the engine reports the absence of a match rather than guessing.',
                    '—', '—');
        }

        $result['abc_type'] = $abcType;
        $result['conflict'] = $result['conflict'] ?? false;
        $result['conflict_reason'] = $result['conflict_reason'] ?? null;

        // Transversal rule — very high CA19-9 on a resectable/borderline tumor (§2.3)
        if (in_array($data['resectability'], ['resectable', 'borderline'], true) && !$cholestasis && $ca199 > 500) {
            $result['transversal_note'] = 'Very high CA19-9 (> 500 U/mL, no cholestasis) suggests possible occult, more extensive disease and reinforces the case for induction treatment before any surgical gesture (§2.3).';
        }

        // R12 overlay — germline BRCA1/2 maintenance, independent of the primary pathway
        $result['overlay_rule'] = null;
        if (($data['brca_mutation'] ?? false) && ($data['stable_16w_on_platinum'] ?? false) && $result['rule_id'] !== 'R7' && $result['rule_id'] !== 'R11') {
            $result['overlay_rule'] = self::rule('R12',
                'Olaparib maintenance',
                'Germline BRCA1/2 mutation with disease non-progression for ≥ 16 weeks on platinum-based chemotherapy — maintenance therapy is indicated regardless of resectability category.',
                '9.5.4.1', 'B');
        }

        return $result;
    }

    /**
     * Compute the ABC stratification type for an anatomically resectable tumor (§2.1).
     */
    private static function classifyAbc(float $ca199, bool $cholestasis, int $ps): string
    {
        $criterionB = !$cholestasis && $ca199 > 500; // Biological
        $criterionC = $ps >= 1;                       // Clinical

        if ($criterionB && $criterionC) return 'ABC';
        if ($criterionB) return 'AB';
        if ($criterionC) return 'AC';
        return 'A';
    }

    private static function rule(string $id, string $recommendation, string $justification, string $source, string $grade): array
    {
        return [
            'rule_id' => $id,
            'recommendation' => $recommendation,
            'justification' => $justification,
            'source' => $source,
            'grade' => $grade,
        ];
    }
}
