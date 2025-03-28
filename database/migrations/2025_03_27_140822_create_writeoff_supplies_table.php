<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWriteoffSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('writeoff_supplies', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name',200);
            $table->string('product_sku_code',200);
            $table->unsignedBigInteger('writeoff_quantities')->default(0);
            $table->text('reason');
            $table->timestamp('added_at');
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
        Schema::dropIfExists('writeoff_supplies');
    }
}
