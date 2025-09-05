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
        Schema::table('irentcar__gamma_office', function (Blueprint $table) {
            $table->unique(['office_id', 'gamma_id'], 'gamma_office_unique');
            $table->decimal('tax', 15, 2)->default(0)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irentcar__gamma_office', function (Blueprint $table) {
            $table->dropUnique('gamma_office_unique');
            $table->dropColumn('tax');
        });
    }
};
