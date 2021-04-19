<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roll_bill', function (Blueprint $table) {
            $table->bigIncrements('roll_billid');
            $table->enum('target',['project','freelancer','bids']);
            $table->bigInteger('customid_lv1')->unsigned();
            $table->bigInteger('customid_lv2')->default(0);
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
        Schema::dropIfExists('roll_bill');
    }
}
