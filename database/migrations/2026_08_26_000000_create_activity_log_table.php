<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Generic activity feed backing the Dashboard's "Recent Activity" panel.
 *
 * Nothing existed for this before — the dashboard blade had 11 activity
 * items hard-coded. Every controller action that should show up in the
 * feed (patient created/updated, status changed, clinical data saved,
 * recommendation generated/validated/rejected/sent to RCP) writes a row
 * here via App\Models\ActivityLog::log(...).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id('activity_id');

            // Type is a short machine key (patient_created, status_changed,
            // clinical_data_updated, recommendation_generated, ...) used to
            // pick the icon in the blade. See ActivityLog::TYPE_* constants.
            $table->string('type', 40);

            // Main line, e.g. "Ahmed Benali's clinical data was updated".
            $table->string('message', 255);

            // Subtext, e.g. "Stage changed to Locally Advanced".
            $table->string('detail', 255)->nullable();

            // The patient this activity is about, if any (dashboard links
            // "Review" back to patients.details). Kept nullable + set null
            // on delete so history survives a patient record being removed.
            $table->unsignedBigInteger('patient_id')->nullable();

            // Who performed the action, if known (auth isn't fully wired
            // yet across the app — see ClinicalDataController TODO).
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->foreign('patient_id')->references('patient_id')->on('patient')->nullOnDelete();
            $table->foreign('user_id')->references('user_id')->on('users')->nullOnDelete();

            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
