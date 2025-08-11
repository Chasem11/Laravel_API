<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('first_name'); 
            $table->string('last_name'); 
            $table->string('email')->unique(); 
            $table->enum('user_type', ['student', 'teacher']); 
            $table->unsignedInteger('grade_level')->nullable(); 
            $table->string('department')->nullable();
            $table->string('gender')->nullable();
            $table->string('password');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
