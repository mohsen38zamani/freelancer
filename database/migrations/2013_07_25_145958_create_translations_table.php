<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translator_translations', function ($table) {
            $table->bigIncrements('id');
            $table->string('locale', 6);
            $table->string('namespace', 50)->default('*');
            $table->string('group', 150);
            $table->longText('item');
            $table->longText('text');
            $table->boolean('unstable')->nullable()->default(0);
            $table->boolean('locked')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('translator_translations');
    }
}
