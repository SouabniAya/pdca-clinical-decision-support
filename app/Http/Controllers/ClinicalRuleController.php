<?php

namespace App\Http\Controllers;

use App\Models\ClinicalRule;
use Illuminate\Http\Request;

class ClinicalRuleController extends Controller
{
    /**
     * List every clinical rule, with the stat cards and filters the
     * repository page displays.
     */
    public function index(Request $request)
    {
        $query = ClinicalRule::query();

        if ($status = $request->input('status')) {
            $query->where('active', $status === 'active');
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('rule_id', 'like', "%$search%")
                  ->orWhere('recommendation', 'like', "%$search%");
            });
        }

        // après (compatible MySQL)
$rules = $query->orderByRaw("CASE WHEN rule_id = 'RCP' THEN 999 ELSE CAST(REPLACE(rule_id, 'R', '') AS UNSIGNED) END")->get();

        return view('patients.rules', [
            'rules' => $rules,
            'totalCount' => ClinicalRule::count(),
            'activeCount' => ClinicalRule::where('active', true)->count(),
            'categoryCount' => ClinicalRule::distinct('category')->count('category'),
            'sourceCount' => ClinicalRule::distinct('source')->count('source'),
        ]);
    }

    /**
     * Full detail of a single rule — what RF-11 traceability points to.
     */
    public function show($id)
    {
        $rule = ClinicalRule::findOrFail($id);

        return view('rules.show', ['rule' => $rule]);
    }

    /**
     * "Add Rule" form.
     */
    public function create()
    {
        return view('rules.form', [
            'rule' => null,
            'categories' => ClinicalRule::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $rule = ClinicalRule::create($data);

        return redirect()
            ->route('rules.show', $rule->clinical_rule_id)
            ->with('success', 'Clinical rule created.');
    }

    public function edit($id)
    {
        $rule = ClinicalRule::findOrFail($id);

        return view('rules.form', [
            'rule' => $rule,
            'categories' => ClinicalRule::CATEGORIES,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rule = ClinicalRule::findOrFail($id);

        $data = $this->validated($request, $rule->clinical_rule_id);

        $rule->update($data);

        return redirect()
            ->route('rules.show', $rule->clinical_rule_id)
            ->with('success', 'Clinical rule updated.');
    }

    public function destroy($id)
    {
        $rule = ClinicalRule::findOrFail($id);
        $rule->delete();

        return redirect()
            ->route('rules.index')
            ->with('success', 'Clinical rule deleted.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        $data = $request->validate([
            'rule_id' => 'required|string|max:10|unique:clinical_rule,rule_id' . ($ignoreId ? ",{$ignoreId},clinical_rule_id" : ''),
            'title' => 'required|string|max:150',
            'category' => 'nullable|string|in:' . implode(',', array_keys(ClinicalRule::CATEGORIES)),
            'conditions' => 'required|string',
            'recommendation' => 'required|string',
            'justification' => 'required|string',
            'source' => 'nullable|string|max:100',
            'grade' => 'nullable|string|max:60',
        ]);

        $data['active'] = $request->boolean('active', true);

        return $data;
    }
}
