<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tumor_evaluation', function (Blueprint $table) {
            $table->boolean('cholestasis')->default(false)->after('ca19_9_level');
            $table->date('ca19_9_date')->nullable()->after('cholestasis');
        });
    }

    public function down(): void
    {
        Schema::table('tumor_evaluation', function (Blueprint $table) {
            $table->dropColumn(['cholestasis', 'ca19_9_date']);
        });
    }
};