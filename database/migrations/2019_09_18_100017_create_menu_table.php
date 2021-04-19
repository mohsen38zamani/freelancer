<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('menuid');
            $table->bigInteger('tabid')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('href')->nullable();
            $table->enum('icon-type', array('icon', 'image'));
            $table->string('icon-name', 50)->nullable();
            $table->string('color', 10)->default('white');
            /* ---- color >>> white,danger,muted,primary,warning,success,info,inverse,pink,purple,dark,bluedark ----*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
