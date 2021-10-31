<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerseSounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verse_sounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('verse_id');
            $table->unsignedBigInteger('reciter_id');
            $table->string('sound')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('verse_id')->references('id')->on('verses')->cascadeOnDelete();
            $table->foreign('reciter_id')->references('id')->on('reciters')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verse_sounds');
    }
}
