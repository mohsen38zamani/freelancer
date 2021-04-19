<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids_project', function (Blueprint $table) {
            $table->bigIncrements('bids_projectid');
            $table->bigInteger('projectid')->unsigned();
            $table->bigInteger('user_profileid')->unsigned();
            $table->float('bid', 30, 2);
            $table->enum('type', ['hour', 'project']);
            $table->string('period_time')->nullable();
            $table->longText('describe')->nullable();
            $table->enum('retract_by', ['employer', 'freelancer'])->nullable();
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
        Schema::dropIfExists('bids_project');
    }
}
