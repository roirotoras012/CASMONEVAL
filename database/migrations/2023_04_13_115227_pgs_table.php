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
        Schema::create('pgs', function (Blueprint $table) {
            $table->id('pgs_ID');
            $table->integer('total_num_of_targeted_measure');
            $table->integer('actual_num_of_accomplished_measure');
            $table->decimal('numeric', 8 , 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pgs');
    }
};
