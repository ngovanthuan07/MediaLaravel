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
        Schema::create('room_details', function (Blueprint $table) {
            $table->id();

            // rooms
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            //posts
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
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
        Schema::table('room_details', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['post_id']);
        });
        Schema::dropIfExists('room_details');
    }
};
