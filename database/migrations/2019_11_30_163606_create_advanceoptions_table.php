<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advanceoption', function (Blueprint $table) {
            $table->bigIncrements('advanceoptionid');
            $table->bigInteger('currencyid')->unsigned();
            $table->string('name');
            $table->boolean('enable')->default(0);
            $table->float('price', 15, 2)->default(0);
            $table->float('discount_percent')->default(0);
            $table->enum('use_in', ['','placeBid','postProject'])->default('');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('advanceoption');
    }
}
