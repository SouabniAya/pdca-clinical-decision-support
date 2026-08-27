<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * `rcp_meeting` — the multidisciplinary team meeting (RCP) record.
 *
 * A Recommendation can be sent to RCP (status = 'rcp'), but until now
 * nothing captured what actually happened in that meeting: when it took
 * place, who attended, what was finally decided, and whether that
 * decision matched the engine's original recommendation. This table
 * is that record (RF-15/16).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rcp_meeting', function (Blueprint $table) {
            $table->id('rcp_meeting_id');
            $table->unsignedBigInteger('recommendation_id')->unique();
            $table->date('meeting_date');
            $table->text('participants'); // free-text list of attendees (names + roles)
            $table->text('final_decision');
            $table->boolean('deviates_from_recommendation')->default(false);
            $table->text('deviation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('recommendation_id')
                ->references('recommendation_id')->on('recommendation')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rcp_meeting');
    }
};
