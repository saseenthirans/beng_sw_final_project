<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->date('taken_date');
            $table->longText('note')->nullable();
            $table->decimal('amount',20,2)->default(0);
            $table->decimal('adv_amount',20,2)->default(0);
            $table->integer('status');
            $table->date('collect_before');
            $table->integer('paid_status');
            $table->date('collected_at')->nullable();
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
        Schema::dropIfExists('repairings');
    }
}
