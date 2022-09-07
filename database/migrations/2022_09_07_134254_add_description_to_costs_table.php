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
        Schema::table('costs', function (Blueprint $table) {
            $table->longText('description')->after('provider_id')->nullable();
            $table->integer('provider_Id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->integer('provider_Id')->change();
        });
    }
};
