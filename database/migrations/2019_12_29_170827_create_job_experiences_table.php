<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_experience', function (Blueprint $table) {
            $table->bigIncrements('job_experienceid');
            $table->bigInteger('user_profileid')->unsigned();
            $table->string('title');
            $table->string('company');
            $table->dateTime('startdate');
            $table->dateTime('enddate');
            $table->text('description')->nullable();
            $table->boolean('currently_working_here')->nullable();
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
        Schema::dropIfExists('job_experience');
    }
}
