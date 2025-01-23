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
        Schema::table('users', function (Blueprint $table) {
            $table->string('parent_email')->nullable();
            $table->string('parent_password')->nullable();
            $table->boolean('is_parent')->default(false);
            $table->unsignedBigInteger('parent_of')->nullable();
            $table->foreign('parent_of')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_of']);
            $table->dropColumn(['parent_email', 'parent_password', 'is_parent', 'parent_of']);
        });
    }
};
