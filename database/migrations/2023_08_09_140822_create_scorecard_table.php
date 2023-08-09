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
        Schema::create('scorecard', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('opcr_ID')->nullable(); // Adjust the column name
        $table->foreign('opcr_ID')->references('opcr_ID')->on('opcr')->nullable();
        $table->unsignedBigInteger('province_ID')->nullable(); // Adjust the column name
        $table->foreign('province_ID')->references('province_ID')->on('provinces')->nullable();
        $table->string('prepared_by')->nullable();
        $table->string('reviewed_by_bdd')->nullable();
        $table->string('reviewed_by_cpd')->nullable();
        $table->string('approved_by')->nullable();
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
        Schema::dropIfExists('scorecard');
    }
};
