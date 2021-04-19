<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wage', function (Blueprint $table) {
            $table->bigIncrements('wageid');
            $table->bigInteger('currencyid')->unsigned();
            $table->string('name');
            $table->enum('type', ['hour', 'project']);
            $table->float('minbudget', 30, 2);
            $table->float('maxbudget', 30, 2);
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
        Schema::dropIfExists('wage');
    }
}
