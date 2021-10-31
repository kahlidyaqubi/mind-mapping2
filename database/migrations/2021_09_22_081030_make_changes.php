<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('verse_images');
        Schema::create('verse_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('verse_id');
            $table->string('image')->nullable();
            $table->integer('from_char')->nullable();
            $table->integer('to_char')->nullable();
            $table->longText('text')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('verse_id')->references('id')->on('verses')->cascadeOnDelete();
        });

        Schema::table('verse_subs', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('verse_subs')->cascadeOnDelete();
        });

       Schema::table('parts', function (Blueprint $table) {
           $table->string('video')->nullable();
           $table->unsignedBigInteger('parent_id')->nullable();
           $table->foreign('parent_id')->references('id')->on('parts')->cascadeOnDelete();
       });

       Schema::table('surahs', function (Blueprint $table) {
           $table->dropColumn('video');
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
