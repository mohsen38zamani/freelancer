<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_card', function (Blueprint $table) {
            $table->bigIncrements('identity_cardid');
            $table->bigInteger('user_profileid')->unsigned();
            $table->string('name');
            $table->string('number', 100)->nullable();
            $table->dateTime('register_date')->nullable();
            $table->dateTime('expire_date')->nullable();
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
        Schema::dropIfExists('identity_card');
    }
}
