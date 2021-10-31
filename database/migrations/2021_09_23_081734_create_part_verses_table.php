<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartVersesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verses', function (Blueprint $table) {
            $table->dropForeign('verses_part_id_foreign');
        });
        Schema::table('verses', function (Blueprint $table) {
            $table->dropColumn('part_id');
        });
        Schema::create('part_verses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('part_id')->nullable();
            $table->unsignedBigInteger('verse_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('part_id')->references('id')->on('parts')->nullOnDelete();
            $table->foreign('verse_id')->references('id')->on('verses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_verses');
    }
}
