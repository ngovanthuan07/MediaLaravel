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
        Schema::create('carts_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->nullable()->default(0);
            $table->double('total')->nullable()->default(0);
            //cart
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            //products
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts_details', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('carts_details');
    }
};
