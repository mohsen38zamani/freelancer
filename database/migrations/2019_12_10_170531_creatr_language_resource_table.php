<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatrLanguageResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_resource', function (Blueprint $table) {
            $table->bigIncrements('language_resourceid');
            $table->bigInteger('tabid')->unsigned();
            $table->bigInteger('fieldid')->unsigned();
            $table->string('locale', 10);
            $table->bigInteger('recordid')->unsigned();
            $table->longText('content');
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
        Schema::dropIfExists('language_resource');
    }
}
