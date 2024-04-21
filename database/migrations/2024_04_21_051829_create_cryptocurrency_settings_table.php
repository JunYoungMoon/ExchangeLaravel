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
        Schema::create('cryptocurrency_setting', function (Blueprint $table) {
            $table->increments('ccs_id')->comment('마켓 ID');
            $table->string('ccs_market_name', 50)->comment('마켓명');
            $table->string('ccs_market_name2', 10)->comment('마켓 unit 명');
            $table->string('ccs_coin_name', 50)->comment('코인명');
            $table->string('ccs_coin_english', 50)->nullable()->comment('코인 영문명');
            $table->string('ccs_coin_chinese', 50)->nullable()->comment('코인 중문명');
            $table->string('ccs_coin_name2', 20)->comment('unit명');
            $table->string('ccs_coin_img', 100)->comment('코인 이미지');
            $table->float('ccs_min_exchange_amount')->comment('최소 거래 가능 수량');
            $table->float('ccs_min_buy_price')->comment('최소 거래 가능 금액');
            $table->decimal('ccs_min_bid', 32, 8)->comment('최저호가');
            $table->float('ccs_deposit_min_amount')->comment('입금 최저 수량');
            $table->float('ccs_withdraw_min_amount')->comment('출금 최저 수량');
            $table->float('ccs_withdraw_commission')->comment('출금 수수료');
            $table->tinyInteger('ccs_exchange_buy')->comment('거래 관리 - 매수');
            $table->tinyInteger('ccs_exchange_sell')->comment('거래 관리 - 매도');
            $table->tinyInteger('ccs_deposit')->comment('입출금 관리 - 입금');
            $table->tinyInteger('ccs_withdraw')->comment('입출금 관리 - 출금');
            $table->float('ccs_commission_rate')->comment('거래 수수료율');
            $table->integer('ccs_order')->comment('for ordering');
            $table->string('ccs_link', 50)->comment('링크');
            $table->tinyInteger('ccs_view_main')->nullable()->default(1)->comment('메인에서 보이게');
            $table->tinyInteger('ccs_view_exchange')->nullable()->default(1)->comment('거래소에서 보이게');
            $table->tinyInteger('ccs_view_wallet')->nullable()->default(1)->comment('지갑에서 보이게');
            $table->decimal('ccs_lv1_value', 32, 8)->nullable()->default(0.00000000);
            $table->decimal('ccs_lv2_value', 32, 8)->nullable()->default(0.00000000);
            $table->decimal('ccs_lv3_value', 32, 8)->nullable()->default(0.00000000);
            $table->decimal('ccs_lv4_value', 32, 8)->nullable()->default(0.00000000);
            $table->decimal('ccs_lv5_value', 32, 8)->nullable()->default(0.00000000);
            $table->string('inAddress', 100)->nullable()->comment('관리자 지갑 주소');
            $table->string('contractAddress', 100)->nullable()->comment('스마트계약');
            $table->tinyInteger('iserc20')->default(0)->comment('erc20 인지');
            $table->string('category', 30)->default('')->comment('카테고리');
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
        Schema::dropIfExists('mg_cryptocurrency_setting');
    }
};
