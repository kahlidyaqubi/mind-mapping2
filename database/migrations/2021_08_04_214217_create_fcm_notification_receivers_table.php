<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcmNotificationReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcm_notification_receivers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('notification_id');
            $table->unsignedBigInteger('receiver_id');

            $table->unique(['notification_id', 'receiver_id']);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('notification_id')->references('id')->on('fcm_notifications')->cascadeOnDelete();
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fcm_notification_receivers');
    }
}
