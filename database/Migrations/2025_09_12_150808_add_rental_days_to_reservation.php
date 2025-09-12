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
        Schema::table('irentcar__reservations', function (Blueprint $table) {
            $table->smallInteger('rental_days')->default(0)->unsigned()->after('gamma_office_extra_total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irentcar__reservations', function (Blueprint $table) {
            $table->dropColumn('rental_days');
        });
    }
};
