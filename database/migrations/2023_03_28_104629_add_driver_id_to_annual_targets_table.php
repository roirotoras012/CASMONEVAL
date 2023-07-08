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
        Schema::table('annual_targets', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_ID')->nullable();

            $table->foreign('driver_ID')->references('driver_ID')->on('drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('annual_targets', function (Blueprint $table) {
            $table->dropColumn('driver_ID');
        });
    }
};
