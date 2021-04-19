<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field', function (Blueprint $table) {
            $table->bigIncrements('fieldid');
            $table->bigInteger('tabid')->unsigned();
            $table->bigInteger('blockid')->unsigned();
            $table->string('tablename');
            $table->string('name');
            $table->enum('type', ['text','number','textarea','select','multiselect','checkbox','file','multifile','password','email','time','date','currency','tags','hidden']);
            $table->longText('option');
            $table->boolean('translator')->default(0);
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
        Schema::dropIfExists('field');
    }

}
