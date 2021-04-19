<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->bigIncrements('user_profileid');
            $table->bigInteger('userid')->unsigned();
            $table->bigInteger('countryid')->unsigned();
            $table->bigInteger('translator_languageid')->unsigned()->comment('translator_languages');
            $table->string('username')->nullable();
            $table->string('name')->nullable();
            $table->string('family')->nullable();
            $table->string('tel', 15)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('companyname')->nullable();
            $table->dateTime('birthday')->nullable();
            $table->boolean('gender')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postcode')->nullable();
            $table->string('hourly_rate_value', 10)->nullable();
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
        Schema::dropIfExists('user_profile');
    }
}
