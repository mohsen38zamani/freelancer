<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemtrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systemtracker', function (Blueprint $table) {
            $table->bigIncrements('systemtrackerid');
            $table->bigInteger('tabid')->unsigned();
            $table->bigInteger('user_profileid')->unsigned();
            $table->bigInteger('recordid')->unsigned();
            $table->boolean('trackmod')->default(1);//1=create, 2=edit, 3=delete
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
        Schema::dropIfExists('systemtracker');
    }
}
