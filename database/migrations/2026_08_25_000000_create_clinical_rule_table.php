<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * `clinical_rule` — the editable, admin-facing catalogue behind the
 * Clinical Rules Repository page.
 *
 * Design note (see App\Services\PdacRuleEngine): the *decision logic*
 * (which rule fires for a given clinical situation) stays in code,
 * since it is safety-critical branching that shouldn't be freely
 * rewritten through a web form without review. What lives here — and
 * is what RF-11 traceability and the admin CRUD actually operate on —
 * is the *display content* of each rule: its title, the plain-language
 * conditions, the recommendation text, its justification, its source
 * and evidence grade. PdacRuleEngine reads this table by rule_id and
 * uses it to render every recommendation, so editing a rule here
 * immediately changes what clinicians see across the app.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinical_rule', function (Blueprint $table) {
            $table->id('clinical_rule_id');
            $table->string('rule_id', 10)->unique(); // R1, R2, ..., R12, RCP
            $table->string('title', 150);
            $table->string('category', 30)->nullable(); // resectable | borderline | locally_advanced | metastatic | overlay | conflict
            $table->text('conditions');                 // plain-language clinical criteria
            $table->text('recommendation');
            $table->text('justification');
            $table->string('source', 100)->nullable();  // e.g. "TNCD §9.5.1"
            $table->string('grade', 60)->nullable();     // e.g. "A", "Expert consensus"
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinical_rule');
    }
};
