<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The notification bell in the header reuses activity_log as its data
 * source (same events, e.g. "new patient registered") rather than
 * duplicating a second event table — it just needs to track what the
 * signed-in clinician has already seen.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->timestamp('read_at')->nullable()->after('causer_name');
        });
    }

    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropColumn('read_at');
        });
    }
};
