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
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opcr_ID')->nullable();
            $table->unsignedBigInteger('division_ID')->nullable();
            $table->unsignedBigInteger('province_ID')->nullable();
            $table->string('file_name');
            $table->string('type');
            $table->timestamps();

            $table->foreign('division_ID')->references('division_ID')->on('divisions')->onDelete('cascade');
            $table->foreign('province_ID')->references('province_ID')->on('provinces')->onDelete('cascade');
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
        Schema::dropIfExists('file_uploads');
    }
};
