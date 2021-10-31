<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcmNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcm_notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sender_id')->nullable();
            $table->enum('action', ['']);
            $table->unsignedInteger('action_id')->nullable();
            $table->boolean('seen')->default(false);
            $table->enum('type', ['customer', 'driver', 'admin_driver', 'restaurant']);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fcm_notifications');
    }
}
