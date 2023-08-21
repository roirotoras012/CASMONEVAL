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
        Schema::table('opcr', function (Blueprint $table) {
            $table->string('prepared_by')->nullable()->after('created_by');
            $table->string('approved_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opcr', function (Blueprint $table) {
            $table->dropColumn('prepared_by');
            $table->dropColumn('approved_by');
        });
    }
};
