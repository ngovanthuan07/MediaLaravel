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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->boolean('public_searchable')->nullable();
            $table->boolean('show_product_in_live')->nullable();
            $table->boolean('dangerous_goods')->nullable();
            $table->string('currency')->nullable();
            $table->double('pricing')->nullable();
            $table->double('discount')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('stock')->nullable();
            $table->string('choose')->nullable();
            $table->integer('views')->nullable();
            $table->string('deleted')->nullable();
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('products');
    }
};
