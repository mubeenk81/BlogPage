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
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users
        // $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Links to posts
        $table->morphs('commentable'); // Creates commentable_id and commentable_type columns
        $table->text('content'); // The content of the comment
        $table->string('photo')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments'); 
    }
};
