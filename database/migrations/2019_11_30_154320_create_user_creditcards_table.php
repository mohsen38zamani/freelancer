<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCreditcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_creditcard', function (Blueprint $table) {
            $table->bigIncrements('user_creditcardid');
            $table->bigInteger('user_profileid')->unsigned();
            $table->string('card_number');
            $table->dateTime('exp')->nullable();
            $table->string('cvv');
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
        Schema::dropIfExists('user_creditcard');
    }
}
