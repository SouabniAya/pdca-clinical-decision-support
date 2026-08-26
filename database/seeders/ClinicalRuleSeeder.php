<?php

namespace Database\Seeders;

use App\Models\ClinicalRule;
use Illuminate\Database\Seeder;

class ClinicalRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            [
                'rule_id' => 'R1',
                'title' => 'Resectable — Type A',
                'category' => 'resectable',
                'conditions' => 'Resectable tumor, Type A (no adverse biological or clinical factor), ECOG 0–1, no surgical contraindication.',
                'recommendation' => 'Curative surgery (DPC or SPG) → adjuvant chemotherapy 6 months (mFOLFIRINOX)',
                'justification' => 'Resectable tumor, Type A (no adverse biological or clinical factor), ECOG 0–1, no surgical contraindication.',
                'source' => 'TNCD §9.5.1',
                'grade' => 'A',
            ],
            [
                'rule_id' => 'R2',
                'title' => 'Resectable — Type AB / AC / ABC',
                'category' => 'resectable',
                'conditions' => 'Resectable tumor, but CA19-9 > 500 U/mL and/or ECOG ≥ 1 (Type AB, AC or ABC).',
                'recommendation' => 'Neoadjuvant chemotherapy to discuss (option)',
                'justification' => 'Resectable tumor but higher-risk Type, reclassifying the tumor as at higher risk despite favorable anatomy — neoadjuvant chemotherapy should be discussed.',
                'source' => 'TNCD §9.5.1',
                'grade' => 'Expert opinion',
            ],
            [
                'rule_id' => 'R3',
                'title' => 'Resectable — Not a surgical candidate',
                'category' => 'resectable',
                'conditions' => 'Anatomically resectable tumor, but severe comorbidities and/or surgical contraindication.',
                'recommendation' => 'Manage as locally advanced',
                'justification' => 'The patient is not a surgical candidate, so the case is managed following the locally advanced pathway.',
                'source' => 'TNCD §9.5.1',
                'grade' => 'Expert opinion',
            ],
            [
                'rule_id' => 'R4',
                'title' => 'Borderline resectable',
                'category' => 'borderline',
                'conditions' => 'Borderline resectable tumor, regardless of ECOG performance status.',
                'recommendation' => 'Systematic mFOLFIRINOX induction chemotherapy — no upfront surgery',
                'justification' => 'Upfront surgery is not indicated for borderline resectable tumors.',
                'source' => 'TNCD §9.5.2',
                'grade' => 'B',
            ],
            [
                'rule_id' => 'R5',
                'title' => 'Locally advanced — ECOG 0-1',
                'category' => 'locally_advanced',
                'conditions' => 'Locally advanced tumor, ECOG 0–1.',
                'recommendation' => 'mFOLFIRINOX induction chemotherapy; reassess resectability at every follow-up',
                'justification' => 'Resectability should be reassessed at each control to allow secondary surgery if downstaging occurs.',
                'source' => 'TNCD §9.5.3',
                'grade' => 'A',
            ],
            [
                'rule_id' => 'R6',
                'title' => 'Locally advanced — ECOG 2',
                'category' => 'locally_advanced',
                'conditions' => 'Locally advanced tumor, ECOG 2.',
                'recommendation' => 'Gemcitabine alone',
                'justification' => 'Locally advanced tumor with reduced performance status (ECOG 2).',
                'source' => 'TNCD §9.5.3',
                'grade' => 'A',
            ],
            [
                'rule_id' => 'R7',
                'title' => 'Locally advanced — ECOG 3-4',
                'category' => 'locally_advanced',
                'conditions' => 'Locally advanced tumor, ECOG 3–4.',
                'recommendation' => 'Best supportive care only',
                'justification' => 'Poor performance status (ECOG 3-4) contraindicates active oncologic treatment.',
                'source' => 'TNCD §9.5.3',
                'grade' => 'Expert consensus',
            ],
            [
                'rule_id' => 'R8',
                'title' => 'Metastatic — ECOG 0-1, age < 75',
                'category' => 'metastatic',
                'conditions' => 'Metastatic disease, ECOG 0–1, age < 75, bilirubin < 1.5x ULN.',
                'recommendation' => 'FOLFIRINOX / mFOLFIRINOX or gemcitabine + nab-paclitaxel',
                'justification' => 'Fit patient with preserved liver function eligible for intensive combination regimens.',
                'source' => 'TNCD §9.5.4.1',
                'grade' => 'A (gem + nab-paclitaxel not reimbursed)',
            ],
            [
                'rule_id' => 'R9',
                'title' => 'Metastatic — ECOG 2',
                'category' => 'metastatic',
                'conditions' => 'Metastatic disease, ECOG 2, bilirubin < 1.5x ULN.',
                'recommendation' => 'Gemcitabine alone',
                'justification' => 'Reduced performance status, single-agent chemotherapy preferred.',
                'source' => 'TNCD §9.5.4.1',
                'grade' => 'A',
            ],
            [
                'rule_id' => 'R10',
                'title' => 'Metastatic — Elevated bilirubin or comorbidities',
                'category' => 'metastatic',
                'conditions' => 'Metastatic disease, ECOG 0–2, with elevated bilirubin (≥ 1.5x ULN) and/or significant comorbidities.',
                'recommendation' => 'Gemcitabine alone',
                'justification' => 'Impaired liver function or comorbidities contraindicate intensive combination regimens.',
                'source' => 'TNCD §9.5.4.1',
                'grade' => 'A',
            ],
            [
                'rule_id' => 'R11',
                'title' => 'Metastatic — ECOG 3-4',
                'category' => 'metastatic',
                'conditions' => 'Metastatic disease, ECOG 3–4.',
                'recommendation' => 'Best supportive care only',
                'justification' => 'Poor performance status contraindicates active oncologic treatment.',
                'source' => 'TNCD §9.5.4.1',
                'grade' => 'Expert consensus',
            ],
            [
                'rule_id' => 'R12',
                'title' => 'BRCA1/2 maintenance therapy (overlay)',
                'category' => 'overlay',
                'conditions' => 'Germline BRCA1/2 mutation with disease non-progression for ≥ 16 weeks on platinum-based chemotherapy — applies on top of the primary pathway, at any resectability stage (except best-supportive-care-only cases).',
                'recommendation' => 'Olaparib maintenance',
                'justification' => 'Maintenance therapy is indicated regardless of resectability category once this criterion is met.',
                'source' => 'TNCD §9.5.4.1',
                'grade' => 'B',
            ],
            [
                'rule_id' => 'RCP',
                'title' => 'Ambiguous case — Referral to RCP',
                'category' => 'conflict',
                'conditions' => 'CA19-9 is at the borderline of the 500 U/mL threshold on a resectable tumor (within ±50 U/mL), making Type A vs Type AB classification ambiguous.',
                'recommendation' => 'Refer to multidisciplinary team meeting (RCP)',
                'justification' => 'Per the rule-conflict management policy, the system does not decide silently when two rules could both apply — it proposes a multidisciplinary review instead.',
                'source' => 'Rule conflict management policy',
                'grade' => 'N/A',
            ],
        ];

        foreach ($rules as $rule) {
            ClinicalRule::updateOrCreate(
                ['rule_id' => $rule['rule_id']],
                $rule + ['active' => true]
            );
        }
    }
}
