<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number', 10)->unique();

            $table->bigInteger('total_cost')->default(0);
            $table->bigInteger('total_discount')->default(0);

            $table->bigInteger('base_cost')->default(0);
            $table->integer('base_qty')->default(1);
            $table->bigInteger('base_discount')->nullable();

            $table->bigInteger('extra_cost')->nullable();
            $table->bigInteger('extra_discount')->nullable();
            $table->integer('extra_qty')->nullable();

            $table->boolean('lifetime')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->timestamp('next_payment_date')->nullable();

            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('affiliate_id')->nullable();

            $table->integer('status')->nullable()->default(\App\Models\Invoice::STATUS_DRAFT);
            $table->text('notes')->nullable();

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
        Schema::dropIfExists('invoices');
    }
}
