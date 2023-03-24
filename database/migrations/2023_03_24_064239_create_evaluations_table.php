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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('evaluation_ID');
            $table->unsignedBigInteger('user_ID');
            $table->string('strategic_measure');
            $table->string('monthly_target');
            $table->string('monthly_accomplishment');
            $table->string('reason')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('user_ID')
                ->references('user_ID')
                ->on('users')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
