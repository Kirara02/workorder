<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_details', function (Blueprint $table) {
            $table->id();
            $table->string('item',25);
            $table->integer('qty');
            $table->string('unit_type',25)->nullable();
            $table->string('unit_code',25)->nullable();
            $table->string('egi',25)->nullable();
            $table->foreignId('workorder_id')->nullable()->constrained('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('work_order_details');
    }
};
