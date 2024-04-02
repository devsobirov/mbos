<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();

            $table->integer('amount');
            $table->integer('left_amount');
            $table->integer('type');
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('invoice_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('user_id');

            $table->timestamp('payment_for_date');
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
        Schema::dropIfExists('payments');
    }
}
