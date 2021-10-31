<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verses', function (Blueprint $table) {
            $table->id();
            $table->longText('text');
            $table->longText('text_pure');
            $table->integer('number');
            $table->unsignedBigInteger('surah_id');
            $table->unsignedBigInteger('part_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('surah_id')->references('id')->on('surahs')->cascadeOnDelete();
            $table->foreign('part_id')->references('id')->on('parts')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verses');
    }
}
