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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->longText("address")->nullable();
            $table->string("email")->nullable();
            $table->string("bank_account_holder_name")->nullable();
            $table->string("bank_account_number")->nullable();
            $table->string("bank_identifier_code")->nullable();
            $table->string("bank_location")->nullable();
            $table->string("bank_currency")->nullable();
            //users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('sellers');
    }
};
