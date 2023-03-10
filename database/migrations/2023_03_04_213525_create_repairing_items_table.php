<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairing_items', function (Blueprint $table) {
            $table->id();
            $table->integer('repairing_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->decimal('amount',20,2)->default(0);
            $table->decimal('total',20,2)->default(0);
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
        Schema::dropIfExists('repairing_items');
    }
}
