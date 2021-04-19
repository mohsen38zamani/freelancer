<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setting', function (Blueprint $table) {
            $table->bigIncrements('user_settingid');
            $table->bigInteger('user_profileid')->unsigned();
            $table->boolean('receive_email')->default(false);
            $table->enum('user_type', ['personal', 'company'])->default('personal');
            $table->boolean('block')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('user_setting', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_setting');
    }
}
