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
        Schema::create('mg_cryptocurrency_setting_detail', function (Blueprint $table) {
            $table->increments('ccsd_id');
            $table->integer('ccs_id')->unsigned()->comment('ccs_id');
            $table->string('ccsd_image', 100)->nullable()->comment('이미지');
            $table->text('ccsd_explan')->nullable()->comment('상세설명');
            $table->string('ccsd_total_raise', 100)->nullable()->comment('총 레이즈');
            $table->string('ccsd_soft_cap', 100)->nullable()->comment('소프트캡');
            $table->string('ccsd_raise_status', 100)->nullable()->comment('레이즈 상태');
            $table->string('ccsd_mini_invest', 100)->nullable()->comment('최소 투자');
            $table->string('ccsd_approve_invest', 100)->nullable()->comment('승인된 투자자');
            $table->string('ccsd_sec_type', 100)->nullable()->comment('보안 유형');
            $table->string('ccsd_exemption', 100)->nullable()->comment('면제');
            $table->string('ccsd_organization', 100)->nullable()->comment('기구');
            $table->string('ccsd_token_price', 100)->nullable()->comment('토큰가격');
            $table->string('ccsd_token_issuer', 100)->nullable()->comment('토큰 발행처');
            $table->string('ccsd_token_protocol', 100)->nullable()->comment('토큰 프로토콜');
            $table->string('ccsd_token_issuer_info', 100)->nullable()->comment('토큰 발행 정보');
            $table->string('ccsd_payment_option', 100)->nullable()->comment('결제 옵션');
            $table->string('ccsd_token_rights', 100)->nullable()->comment('토큰 권리');
            $table->timestamps();

            // Add foreign key constraint if needed
            // $table->foreign('ccs_id')->references('ccs_id')->on('related_table_name')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mg_cryptocurrency_setting_detail');
    }
};
