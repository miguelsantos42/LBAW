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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->useCurrent();
            $table->text('title');
            $table->text('content');
            $table->integer('voteCount')->default(0);
            $table->boolean('edited')->default(false);
            $table->foreignId('usersId')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('isDeleted')->default(false);
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
