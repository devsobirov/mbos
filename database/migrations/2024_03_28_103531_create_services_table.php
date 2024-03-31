<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->integer('cost');

            $table->integer('status')->nullable()->default(\App\Models\Plan::STATUS_ACTIVE);
            $table->timestamp('cancelled_at')->nullable();
            $table->integer('cancelled_with_paid_sum')->nullable();

            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('plan_id');
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
        Schema::dropIfExists('services');
    }
}
