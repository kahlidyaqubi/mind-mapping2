<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->text('ip_address')->nullable();
            $table->text('device')->nullable();
            $table->text('device_platform')->nullable();
            $table->text('agent')->nullable();
            $table->boolean('path_status')->default(0);
            $table->boolean('is_notify')->default(0);
            $table->string('logable_type')->nullable();
            $table->integer('logable_id')->unsigned()->nullable();
            $table->unsignedInteger('permission_id');

            /* $table->foreign('permission_id')->references('id')->on('permissions');
             $table->foreign('admin_id')->references('id')->on('admins');*/
            $table->softDeletes();
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
        Schema::dropIfExists('logs');
    }
}
