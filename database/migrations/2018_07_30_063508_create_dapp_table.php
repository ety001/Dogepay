<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dapp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('app_name')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('secret_key', 32);
            $table->string('callback_url')->nullable();
            $table->string('withdraw_addr')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dapp', function (Blueprint $table) {
            $table->dropForeign('dapp_user_id_foreign');
        });
        Schema::dropIfExists('dapp');
    }
}
