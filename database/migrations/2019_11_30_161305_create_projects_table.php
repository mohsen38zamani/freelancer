<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('projectid');
            $table->string('name');
            $table->bigInteger('user_profileid')->unsigned();
            $table->bigInteger('wageid')->unsigned();
            $table->bigInteger('assistant_settingid')->unsigned();
            $table->longText('description');
            $table->enum('state', ['opened','closed'])->nullable();
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
        Schema::dropIfExists('project');
    }
}
