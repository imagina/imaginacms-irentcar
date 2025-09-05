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
        Schema::table('irentcar__gamma_office_extra', function (Blueprint $table) {
            $table->unique(['gamma_office_id', 'extra_id'], 'gamma_extra_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irentcar__gamma_office_extra', function (Blueprint $table) {
            $table->dropUnique('gamma_extra_unique');
        });
    }
};
