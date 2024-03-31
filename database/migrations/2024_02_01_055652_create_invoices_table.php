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
            $table->bigInteger('total_cancelled')->default(0);

            $table->bigInteger('percent_discount')->nullable();
            $table->bigInteger('percent_discount_sum')->nullable();
            $table->bigInteger('fixed_discount')->nullable();

            $table->timestamp('next_payment_date')->nullable();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('project_id');

            $table->integer('status')->nullable()->default(\App\Models\Invoice::STATUS_ACTIVE);
            $table->text('notes')->nullable();

            $table->timestamp('archived_at')->nullable();
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
