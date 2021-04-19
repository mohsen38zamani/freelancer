<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillFreelancersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_freelancer', function (Blueprint $table) {
            $table->bigIncrements('skill_freelancerid');
            $table->bigInteger('freelancerinfoid')->unsigned();
            $table->bigInteger('lv1skillid')->unsigned();
            $table->bigInteger('skillid')->unsigned();
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
        Schema::dropIfExists('skill_freelancer');
    }
}
