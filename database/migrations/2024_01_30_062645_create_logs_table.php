<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();

            $table->string('event');
            $table->text('message')->nullable();
            $table->integer('log_type')->nullable()
                ->default(\App\Helpers\LogTypeHelper::TYPE_INFO);
            $table->string('group_type')->nullable();
            $table->string('group_type_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
