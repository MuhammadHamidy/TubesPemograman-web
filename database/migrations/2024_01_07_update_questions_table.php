<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'image' or 'text'
            $table->string('value');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->string('correct_answer')->after('image');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_options');
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('correct_answer');
        });
    }
}; 