<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserByTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_by_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_type_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_type_id')->references('id')->on('user_types');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_by_types');
    }
}
