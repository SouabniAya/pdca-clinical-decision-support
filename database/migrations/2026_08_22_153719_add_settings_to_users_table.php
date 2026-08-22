<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_new_patient')->default(true);
            $table->boolean('notify_weekly_summary')->default(false);
            $table->boolean('dark_mode')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notify_email',
                'notify_new_patient',
                'notify_weekly_summary',
                'dark_mode',
            ]);
        });
    }
};