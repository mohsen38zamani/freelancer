<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectAdvanceoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_advanceoption', function (Blueprint $table) {
            $table->bigIncrements('project_advanceoptionid');
            $table->bigInteger('advanceoptionid')->unsigned();
            $table->bigInteger('projectid')->unsigned();
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
        Schema::dropIfExists('project_advanceoption');
    }
}
