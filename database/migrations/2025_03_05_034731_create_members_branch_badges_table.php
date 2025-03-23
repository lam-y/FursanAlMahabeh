<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersBranchBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_branch_badges', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('CASCADE');

            $table->unsignedBigInteger('branch_badges_id')->nullable();
            $table->foreign('branch_badges_id')->references('id')->on('branch_badges')->onDelete('SET NULL');

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
        Schema::dropIfExists('members_branch_badges');
    }
}
