<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->integer('supplier_id');
            $table->date('pur_date');
            $table->decimal('pur_amount',20,2);
            $table->decimal('discount',20,2);
            $table->string('inv_file');
            $table->integer('status')->default(0)->comment('0 = Not Settled 1 = Settled');
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
        Schema::dropIfExists('purchases');
    }
}
