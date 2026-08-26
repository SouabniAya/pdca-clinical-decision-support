<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the fields needed to store the full, traceable output of
 * App\Services\PdacRuleEngine on each recommendation (RNF-01 / RNF-06 —
 * every recommendation must be explainable, not a black box).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recommendation', function (Blueprint $table) {
            $table->string('rule_id', 10)->nullable()->after('recommendation_type');
            $table->text('recommendation_text')->nullable()->after('rule_id');
            $table->text('justification')->nullable()->after('recommendation_text');
            $table->string('source', 100)->nullable()->after('justification');
            $table->string('grade', 60)->nullable()->after('source');
            $table->string('abc_type', 5)->nullable()->after('grade');
            $table->boolean('conflict')->default(false)->after('abc_type');
            $table->text('conflict_reason')->nullable()->after('conflict');
            // Anything extra (transversal note, R12 overlay rule, etc.)
            $table->json('details')->nullable()->after('conflict_reason');
        });
    }

    public function down(): void
    {
        Schema::table('recommendation', function (Blueprint $table) {
            $table->dropColumn([
                'rule_id', 'recommendation_text', 'justification',
                'source', 'grade', 'abc_type', 'conflict', 'conflict_reason', 'details',
            ]);
        });
    }
};
