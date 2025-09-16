<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irentcar__gamma_office', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('irentcar__offices')->onDelete('restrict');

            $table->integer('gamma_id')->unsigned();
            $table->foreign('gamma_id')->references('id')->on('irentcar__gammas')->onDelete('restrict');

            $table->integer('quantity')->default(0)->unsigned();
            $table->decimal('price', 15, 2)->default(0);

            $table->decimal('tax', 15, 2)->default(0);
            $table->tinyInteger('status_id')->default(1)->unsigned();

            //Unique
            $table->unique(['office_id', 'gamma_id'], 'gamma_office_unique');

            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('irentcar__gamma_office');
    }
};
