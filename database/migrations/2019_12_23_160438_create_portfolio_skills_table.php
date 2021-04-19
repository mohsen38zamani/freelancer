<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_skill', function (Blueprint $table) {
            $table->bigIncrements('portfolio_skillid');
            $table->bigInteger('portfolioid')->unsigned();
            $table->bigInteger('skillid')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('portfolio_skill', function ($table) {
            $table->foreign('portfolioid')->references('portfolioid')->on('portfolio')->onDelete('RESTRICT');
            $table->foreign('skillid')->references('skillid')->on('skill')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolio_skillid');
    }
}
