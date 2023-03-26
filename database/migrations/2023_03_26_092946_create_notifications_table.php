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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_type_ID')->nullable();
            $table->unsignedBigInteger('user_ID')->nullable();
            $table->unsignedBigInteger('division_ID')->nullable();
            $table->unsignedBigInteger('province_ID')->nullable();
            $table->unsignedBigInteger('opcr_ID')->nullable();
            $table->year('year')->nullable();
            $table->string('type');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        
         
            $table->foreign('user_type_ID')->references('user_type_ID')->on('user_types')->onDelete('cascade');
            $table->foreign('user_ID')->references('user_ID')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('notifications');
    }
};
