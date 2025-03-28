<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\SellerProfile;
use App\Models\PhysicalShop;

class CreateWebshopsInitial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sellers = SellerProfile::select('shop_name', 'address')->get();

        foreach ($sellers as $seller) {
            PhysicalShop::updateOrCreate(
                [
                    'name' => $seller->shop_name,
                    'address' => $seller->address,
                ],
                [
                    'is_web_shop' => true,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optional: You can delete the created physical shops if needed
        PhysicalShop::where('is_web_shop', true)->delete();
    }
}
