<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_targets', function (Blueprint $table) {
            $table->id('monthly_target_ID');
            $table->integer('annual_target_ID');
            $table->string('month');
            $table->string('year');
            $table->integer('monthly_target')->nullable();
            $table->integer('monthly_accomplishment')->nullable();
            $table->String('validated')->default('Not Validated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_targets');
    }
};
