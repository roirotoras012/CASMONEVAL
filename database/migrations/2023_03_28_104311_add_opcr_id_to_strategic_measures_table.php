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
        Schema::table('strategic_measures', function (Blueprint $table) {
            $table->unsignedBigInteger('opcr_ID')->nullable();

            $table->foreign('opcr_ID')->references('opcr_ID')->on('opcr')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('strategic_measures', function (Blueprint $table) {
            $table->dropColumn('opcr_ID');
        });
    }
};
