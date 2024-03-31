<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('plan_id');


            $table->timestamp('start_date')->nullable();
            $table->timestamp('expire_date')->nullable();

            $table->bigInteger('base_price')->default(0);
            $table->bigInteger('extra_price')->nullable();
            $table->integer('extra_qty')->nullable();


            $table->integer('qty')->default(1);
            $table->bigInteger('cost');

            $table->integer('status')->nullable()->default(\App\Models\Plan::STATUS_ACTIVE);
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('cancelled_with_paid_sum')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
