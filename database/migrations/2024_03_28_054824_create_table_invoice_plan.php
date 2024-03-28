<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvoicePlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_invoice_plan', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->integer('price');
            $table->integer('cost');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_invoice_plan');
    }
}
