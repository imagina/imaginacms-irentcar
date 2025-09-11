<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('irentcar__daily_availabilities', function (Blueprint $table) {
            $table->unique(['gamma_office_id', 'available_date'], 'unique_gamma_office_ad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irentcar__daily_availabilities', function (Blueprint $table) {
            $table->dropUnique('unique_gamma_office_ad');
        });
    }
};
