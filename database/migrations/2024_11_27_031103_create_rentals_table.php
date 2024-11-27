<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('renter_id'); 
            $table->date('rental_date'); 
            $table->date('return_date')->nullable(); 
            $table->boolean('returned')->default(false);
            $table->unsignedBigInteger('book_id')->nullable(); 
            $table->unsignedBigInteger('movie_id')->nullable();

            // Foreign key constraints
            $table->foreign('renter_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('item_id')->on('books')->onDelete('cascade');
            $table->foreign('movie_id')->references('item_id')->on('movies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
}
