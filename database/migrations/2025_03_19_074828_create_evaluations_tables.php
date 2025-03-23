<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table){
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->string('text');
            $table->timestamps();
        });

        Schema::create('evaluations', function (Blueprint $table){
            $table->id();

            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');

            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table){
            $table->id();

            $table->unsignedBigInteger('evaluation_id')->nullable();
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');

            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');

            $table->string('text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('answers');
    }
}
