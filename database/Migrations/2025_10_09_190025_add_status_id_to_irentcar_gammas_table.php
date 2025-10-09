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
        Schema::table('irentcar__gammas', function (Blueprint $table) {
            $table->tinyInteger('status_id')->default(1)->unsigned()->after('options');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irentcar__gammas', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
};
