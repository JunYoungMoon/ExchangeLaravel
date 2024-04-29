<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_coin_favors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('symbol',50)->nullable();
            $table->timestamps();
        });

        Schema::table('member_coin_favors', function (Blueprint $table) {
            $table->index(['id', 'symbol']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_coin_favors');
    }
};
