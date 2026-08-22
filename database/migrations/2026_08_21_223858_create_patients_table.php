<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table 'patient' déjà créée par data_base.sql.
        // On ajoute juste la colonne 'status' qui n'existe pas dans le schéma original.
        Schema::table('patient', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('medical_record_number');
        });
    }

    public function down(): void
    {
        Schema::table('patient', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};