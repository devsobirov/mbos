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

            $table->float('total_cost')->default(0);
            $table->float('total_discount')->default(0);

            $table->float('base_cost')->default(0);
            $table->float('base_qty')->default(1);
            $table->float('base_discount')->nullable();

            $table->float('extra_cost')->nullable();
            $table->float('extra_discount')->nullable();
            $table->float('extra_qty')->nullable();

            $table->boolean('lifetime')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('expire_date')->nullable();

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
