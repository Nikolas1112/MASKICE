<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsWebShopFieldToPhysicalShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('physical_shops', function (Blueprint $table) {
            $table->boolean('is_web_shop')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('physical_shops', function (Blueprint $table) {
            $table->dropColumn(['is_web_shop']);
        });
    }
}
