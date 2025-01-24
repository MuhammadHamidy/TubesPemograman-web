<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('game_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('level');  // motorik-1, motorik-2, etc.
            $table->integer('correct_answers');
            $table->integer('total_questions');
            $table->integer('points_earned');
            $table->integer('points_before');
            $table->integer('points_after');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_history');
    }
}; 