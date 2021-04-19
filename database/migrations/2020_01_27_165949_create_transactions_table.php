<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('transactionid');
            $table->bigInteger('user_profileid')->unsigned();
            $table->string('transaction_name')->nullable();
            $table->string('orderid')->nullable();
            $table->string('paypal_transactionid')->nullable();
            $table->string('status')->nullable();
            $table->float('price', 15, 2)->nullable()->default(0);
            $table->longText('paypal_description')->nullable();
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
        Schema::dropIfExists('transaction');
    }
}
