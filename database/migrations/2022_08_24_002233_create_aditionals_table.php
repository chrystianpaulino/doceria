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
        Schema::create('aditionals', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->longText('long_description')->nullable();
            $table->string('picture')->default('product-default.jpg');
            $table->bigInteger('price')->unsigned();
            $table->string('status')->default('00');
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
        Schema::dropIfExists('aditionals');
    }
};
