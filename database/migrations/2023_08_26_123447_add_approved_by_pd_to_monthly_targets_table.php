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
        Schema::table('monthly_targets', function (Blueprint $table) {
            $table->boolean('approved_by_pd')->nullable()->default(0)->after('validated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_targets', function (Blueprint $table) {
            $table->dropColumn('approved_by_pd');
        });
    }
};
