<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab', function (Blueprint $table) {
            $table->bigIncrements('tabid');
            $table->string('name');
            $table->string('tablename');
            $table->boolean('hascustomfield');
            $table->boolean('usecustomfield');
            $table->boolean('isentity');
            $table->string('folder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tab');
    }
}
