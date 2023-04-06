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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string("role")->nullable()->default("MEMBER");
            $table->string("status")->nullable();

            // rooms
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
        });
        Schema::dropIfExists('members');
    }
};
