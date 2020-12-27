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
        Schema::create('user_by_type', function (Blueprint $table) {
            
            $table->id();
            $table->integer('user_types_id');
            $table->integer('users_id');
            $table->foreign('user_types_id')->references('id')->on('user_types');
            $table->foreign('users_id')->references('id')->on('users');
            $table->string('status');
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
        Schema::dropIfExists('user_by_type');
      //  tried: $table->dropForeign('user_id'); $
        //table->dropIndex('user_id');
         //$table->dropColumn('user_id'); 
    }
}
