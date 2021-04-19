<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificationlist', function (Blueprint $table) {
            $table->bigIncrements('certificationlistid');
            $table->string('name');
            $table->enum('credit', ['local', 'international'])->default('local');
            $table->enum('level', [1, 2, 3, 4, 5])->default(1);
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
        Schema::dropIfExists('certificationlist');
    }
}
