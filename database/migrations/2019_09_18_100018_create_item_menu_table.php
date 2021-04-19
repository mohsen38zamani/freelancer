<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_menu', function (Blueprint $table) {
            $table->bigIncrements('item_menuid');
            $table->bigInteger('menuid')->unsigned();
            $table->bigInteger('tabid')->unsigned();
            $table->string('name')->nullable();
            $table->string('href')->nullable();
            $table->enum('icon-type', array('icon', 'image'));
            $table->string('icon-name', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_menu');
    }
}
