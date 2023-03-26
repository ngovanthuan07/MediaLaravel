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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->string('watch')->nullable();
            $table->string('options')->nullable();
            $table->integer('public_searchable')->nullable();
            $table->integer('show_product_in_live')->nullable();
            $table->integer('dangerous_goods')->nullable();
            $table->string('currency')->nullable();
            $table->double('pricing')->nullable();
            $table->double('stock')->nullable();
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
        Schema::dropIfExists('posts');
    }
};
