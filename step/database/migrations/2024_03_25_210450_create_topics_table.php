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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('topic_name');
            $table->string('description');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_public')->default(false);
            $table->integer('like_count');
            $table->integer('dislike_count');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
