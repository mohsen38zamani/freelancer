<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_project', function (Blueprint $table) {
            $table->bigIncrements('manage_projectid');
            $table->bigInteger('projectid')->unsigned();
            $table->bigInteger('bids_projectid')->unsigned();
            $table->dateTime('start_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('end_date')->nullable();
            $table->enum('status_project',['working','ending'])->default('working');
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
        Schema::dropIfExists('manage_project');
    }
}
