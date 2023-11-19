<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->unsignedBigInteger('question_id');
            $table->integer('voteCount')->default(0);
            $table->boolean('edited')->default(false);
            $table->unsignedBigInteger('usersId');
            $table->boolean('isDeleted')->default(false);
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('usersId')->references('id')->on('users')->onDelete('cascade');
            // Add any other fields and foreign key constraints you need
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment');
    }
}
