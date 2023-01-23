<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('inv_id');
            $table->integer('sale_type')->comment('1 = Percentage 2 = Amount');
            $table->decimal('amount', 20,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default(0)->comment('0 = Inactive 1 = Active');
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
        Schema::dropIfExists('sales');
    }
}
