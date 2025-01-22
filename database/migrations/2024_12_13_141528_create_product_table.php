<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('ProductID'); // Primary key
            
            $table->unsignedBigInteger('CategoryID');
            $table->foreign('CategoryID')->references('CategoryID')->on('category')->onDelete('cascade');

            $table->string('Name', 100);
            $table->float('Price');
            $table->string('UniqueIdentifier', 50)->unique(); // Add the unique identifier column
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
        Schema::dropIfExists('product');
    }
};
