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
        Schema::create('cost_feedstocks', function (Blueprint $table) {
            $table->id();
            $table->integer('cost_id');
            $table->integer('feedstock_id');
            $table->integer('quantity');
            $table->bigInteger('price');
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('total');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_feedstocks');
    }
};
