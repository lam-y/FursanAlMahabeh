<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContactMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_messages', function($table) {
            $table->date('birthdate')->nullable();
            $table->string('school')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id')->references('id')->on('grades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_messages', function($table) {
            $table->dropColumn('birthdate');
            $table->dropColumn('school');
            $table->dropForeign(['grade_id']);
            $table->dropColumn('birthdate');
        });
    }
}
