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
            $table->string('ref_no');
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->date('invoice_date');
            $table->decimal('sub_total',20,2);
            $table->decimal('tax_amount',20,2);
            $table->decimal('disc_percentage',20,2)->default(0);
            $table->decimal('disc_amount',20,2)->default(0);
            $table->integer('status')->default(0)->comment('0 = Unsettled 1 = Settled');
            $table->timestamps();
            $table->softDeletes();
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
