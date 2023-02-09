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
        Schema::create('registration_keys', function (Blueprint $table) {
            $table->id('registration_key_ID');
            $table->string('registration_key');
            $table->string('Status')->default('unused');
            $table->integer('user_type_ID');
            $table->string('province')->nullable();
            $table->string('division')->nullable();
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
        Schema::dropIfExists('registration_keys');
    }
};
