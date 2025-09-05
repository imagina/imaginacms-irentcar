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
            $table->decimal('gamma_office_tax', 15, 2)->default(0)->after('gamma_office_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irentcar__reservations', function (Blueprint $table) {
            $table->dropColumn('gamma_office_tax');
        });
    }
};
