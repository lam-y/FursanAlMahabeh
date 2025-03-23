<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersPublicBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_public_badges', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('CASCADE');

            $table->unsignedBigInteger('public_badge_id')->nullable();
            $table->foreign('public_badge_id')->references('id')->on('public_badges')->onDelete('SET NULL');

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
        Schema::dropIfExists('members_public_badges');
    }
}
