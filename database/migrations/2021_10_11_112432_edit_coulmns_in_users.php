<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCoulmnsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable();
            $table->unsignedBigInteger('reciter_id')->nullable();
            $table->boolean('sound_on')->default(1);
            $table->boolean('alert_on')->default(1);
            $table->integer('repeat_num')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
