<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('base_amount')->default(1);
            $table->integer('base_price');

            $table->integer('per_extra_amount')->nullable();
            $table->integer('per_extra_price')->nullable();

            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('project_id')->index();

            $table->boolean('status');
            $table->boolean('is_expirable');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
