<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Foundational schema for the PDAC Clinical Decision Support System.
 *
 * The rest of the migration set (add_columns_to_tumor_evaluation_table,
 * add_phone_location_to_users_table, etc.) assumes these base tables
 * already exist — their comments reference a `data_base.sql` file that
 * is not present in this branch. This migration recreates that base
 * schema directly in Laravel so the project can be installed from a
 * clean database with nothing but `php artisan migrate`.
 *
 * Every table is wrapped in a Schema::hasTable() guard, so this is safe
 * to run even on a database where the tables were already created some
 * other way.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ------------------------------------------------------------
        // users (doctors / nurses / visitors share this table)
        // ------------------------------------------------------------
        if (! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id('user_id');
                $table->string('first_name', 100);
                $table->string('last_name', 100);
                $table->string('email', 150)->unique();
                $table->string('password');
                $table->boolean('active')->default(true);
                $table->rememberToken();
                $table->timestamp('created_at')->nullable();
            });
        }

        // ------------------------------------------------------------
        // admin (separate auth guard — see config/auth.php)
        // ------------------------------------------------------------
        if (! Schema::hasTable('admin')) {
            Schema::create('admin', function (Blueprint $table) {
                $table->id('admin_id');
                $table->string('first_name', 100);
                $table->string('last_name', 100);
                $table->string('email', 150)->unique();
                $table->string('password');
                $table->boolean('active')->default(true);
                $table->rememberToken();
                $table->timestamp('created_at')->nullable();
            });
        }

        // ------------------------------------------------------------
        // doctor / nurse / visitor — 1-to-1 role extensions of users
        // ------------------------------------------------------------
        if (! Schema::hasTable('doctor')) {
            Schema::create('doctor', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->primary();
                $table->string('license_number', 50)->unique();
                $table->string('specialty', 100)->nullable();
                $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            });
        }

        if (! Schema::hasTable('nurse')) {
            Schema::create('nurse', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->primary();
                $table->string('license_number', 50)->unique();
                $table->string('department', 100)->nullable();
                $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            });
        }

        if (! Schema::hasTable('visitor')) {
            Schema::create('visitor', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->primary();
                $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            });
        }

        // ------------------------------------------------------------
        // patient
        // ------------------------------------------------------------
        if (! Schema::hasTable('patient')) {
            Schema::create('patient', function (Blueprint $table) {
                $table->id('patient_id');
                $table->string('first_name', 100);
                $table->string('last_name', 100);
                $table->date('date_of_birth');
                $table->enum('sex', ['M', 'F']);
                $table->string('medical_record_number', 50)->unique();
                $table->timestamp('created_at')->nullable();
            });
        }

        // ------------------------------------------------------------
        // comorbidity (reference list: diabetes, cardiac history, etc.)
        // ------------------------------------------------------------
        if (! Schema::hasTable('comorbidity')) {
            Schema::create('comorbidity', function (Blueprint $table) {
                $table->id('comorbidity_id');
                $table->string('label', 150);
                $table->string('type', 50)->nullable();
            });
        }

        // ------------------------------------------------------------
        // consultation
        // ------------------------------------------------------------
        if (! Schema::hasTable('consultation')) {
            Schema::create('consultation', function (Blueprint $table) {
                $table->id('consultation_id');
                $table->unsignedBigInteger('patient_id');
                $table->unsignedBigInteger('doctor_id');
                $table->dateTime('consultation_date');
                $table->unsignedTinyInteger('performance_status'); // ECOG 0-4
                $table->string('clinical_stage', 50)->nullable();

                $table->foreign('patient_id')->references('patient_id')->on('patient')->cascadeOnDelete();
                $table->foreign('doctor_id')->references('user_id')->on('doctor')->cascadeOnDelete();
            });
        }

        // ------------------------------------------------------------
        // tumor_evaluation (base columns — cholestasis/ca19_9_date
        // are added by the later add_columns_to_tumor_evaluation_table
        // migration, kept as-is to preserve existing migration history)
        // ------------------------------------------------------------
        if (! Schema::hasTable('tumor_evaluation')) {
            Schema::create('tumor_evaluation', function (Blueprint $table) {
                $table->id('evaluation_id');
                $table->unsignedBigInteger('consultation_id');
                $table->enum('resectability', ['resectable', 'borderline', 'locally_advanced', 'metastatic']);
                $table->decimal('ca19_9_level', 10, 2)->nullable();
                $table->boolean('surgery_contraindication')->default(false);
                $table->text('comments')->nullable();

                $table->foreign('consultation_id')->references('consultation_id')->on('consultation')->cascadeOnDelete();
            });
        }

        // ------------------------------------------------------------
        // consultation_comorbidity (pivot)
        // ------------------------------------------------------------
        if (! Schema::hasTable('consultation_comorbidity')) {
            Schema::create('consultation_comorbidity', function (Blueprint $table) {
                $table->unsignedBigInteger('consultation_id');
                $table->unsignedBigInteger('comorbidity_id');
                $table->enum('severity', ['mild', 'moderate', 'severe'])->nullable();

                $table->primary(['consultation_id', 'comorbidity_id']);
                $table->foreign('consultation_id')->references('consultation_id')->on('consultation')->cascadeOnDelete();
                $table->foreign('comorbidity_id')->references('comorbidity_id')->on('comorbidity')->cascadeOnDelete();
            });
        }

        // ------------------------------------------------------------
        // recommendation (base columns — rule engine fields are added
        // by add_rule_engine_fields_to_recommendation_table)
        // ------------------------------------------------------------
        if (! Schema::hasTable('recommendation')) {
            Schema::create('recommendation', function (Blueprint $table) {
                $table->id('recommendation_id');
                $table->unsignedBigInteger('consultation_id');
                $table->string('recommendation_type', 20)->nullable();
                $table->dateTime('generation_date')->nullable();
                $table->string('status', 20)->default('proposed'); // proposed | validated | rejected | rcp

                $table->foreign('consultation_id')->references('consultation_id')->on('consultation')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation');
        Schema::dropIfExists('consultation_comorbidity');
        Schema::dropIfExists('tumor_evaluation');
        Schema::dropIfExists('consultation');
        Schema::dropIfExists('comorbidity');
        Schema::dropIfExists('patient');
        Schema::dropIfExists('visitor');
        Schema::dropIfExists('nurse');
        Schema::dropIfExists('doctor');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('users');
    }
};
