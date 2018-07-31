<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dapp_id');
            $table->string('trade_no');
            $table->string('amount');
            $table->integer('precision');
            $table->string('sender_addr')->nullable();
            $table->string('receiver_addr')->nullable();
            $table->string('tx_id')->nullable();
            $table->integer('retry')->default(0);
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->foreign('dapp_id')->references('id')->on('dapp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_dapp_id_foreign');
        });
        Schema::dropIfExists('orders');
    }
}
