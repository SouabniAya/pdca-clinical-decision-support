<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Backs the Dashboard "Recent Activity" feed with real, persisted
 * events instead of hardcoded HTML. Kept intentionally simple
 * (no polymorphic relations) so any part of the app can log an
 * event with a single ActivityLog::log(...) call.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('activity_log')) {
            Schema::create('activity_log', function (Blueprint $table) {
                $table->id('activity_id');

                // e.g. patient_created, patient_updated, patient_status_changed,
                // clinical_data_updated, recommendation_generated, recommendation_status_changed
                $table->string('type', 50);

                // Main line, e.g. "New patient Karim Ferhat was registered"
                $table->string('description', 255);

                // Subtitle, e.g. "Added by Dr. Meziane" / "Stage changed to Locally Advanced"
                $table->string('detail', 255)->nullable();

                // What this event is about (loosely typed on purpose — no FK,
                // so a deleted patient doesn't break historical activity rows)
                $table->string('subject_type', 30)->nullable();
                $table->unsignedBigInteger('subject_id')->nullable();

                // Display name of who triggered it (doctor/admin), if known
                $table->string('causer_name', 150)->nullable();

                $table->timestamp('created_at')->useCurrent();

                $table->index(['subject_type', 'subject_id']);
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
