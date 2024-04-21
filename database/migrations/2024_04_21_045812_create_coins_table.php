<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->string('coin_name', 100)->comment('코인명');
            $table->string('coin_type', 30)->comment('Unit명칭');
            $table->string('logo', 255)->nullable()->comment('로고_이미지');
            $table->decimal('trade_min_amount', 32, 8)->nullable()->comment('최소거래가능한수량');
            $table->dateTime('reg_date')->nullable()->comment('등록일');
            $table->decimal('commition', 32, 2)->comment('커미션율');
            $table->integer('min_order')->comment('최소 구매 금액');
            $table->decimal('min_hoga', 10, 2)->comment('최소 호가');
            $table->integer('buy_able')->comment('구매 가능 여부');
            $table->integer('sell_able')->comment('판매 가능 여부');
            $table->integer('deposit_able')->comment('입금 가능 여부');
            $table->integer('withdraw_able')->comment('출금 가능 여부');
            $table->decimal('withdraw_commition', 32, 4)->nullable()->comment('출금 커미션');
            $table->integer('coin_no');
            $table->string('wallet', 255)->nullable();
            $table->string('qr_code', 255)->nullable();
            $table->primary(['coin_name', 'coin_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
};
