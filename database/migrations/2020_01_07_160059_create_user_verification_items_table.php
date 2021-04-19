<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVerificationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verification_items', function (Blueprint $table) {
            $table->bigIncrements('user_verification_itemsid');
            $table->bigInteger('user_profileid')->unsigned();
            $table->boolean('facebook')->default(0);
            $table->boolean('payment')->default(0);
            $table->boolean('phone')->default(0);
            $table->boolean('email')->default(0);
            $table->boolean('identity')->default(0);
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
        Schema::dropIfExists('user_verification_items');
    }
}
