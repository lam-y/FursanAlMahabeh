<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('member_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('school')->nullable();
            $table->date('register_date')->nullable();
            $table->boolean('foulard')->nullable();
            $table->boolean('junior_degree')->nullable();
            $table->boolean('second_degree')->nullable();
            $table->boolean('promoted')->nullable();
            $table->boolean('totem')->nullable();
            $table->string('totem_name')->nullable();

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');

            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id')->references('id')->on('grades');

            $table->unsignedBigInteger('member_type_id')->nullable();
            $table->foreign('member_type_id')->references('id')->on('member_types');

            $table->unsignedBigInteger('branch_badge_id')->nullable();
            $table->foreign('branch_badge_id')->references('id')->on('branch_badges');

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
        Schema::dropIfExists('members');
    }
}
