<?php

namespace App\Repositories\Interfaces\Admin;

interface ReportsInterface
{

    public function wishlist($request, $limit);

    public function searches($request, $limit);

    public function stockProduct($request, $limit);

    public function product($request, $limit, $for);

    public function commissionHistory($request, $limit);

    public function walletRechargeHistory($request, $limit);

    public function totalOrderCount($timePeriod);

    public function totalAmountOfOrder($timePeriod);

    public function totalOrderWithFees($timePeriod);

    public function totalOrderWithoutFees($timePeriod);

    public function averageOrdersPerDay($timePeriod);

    public function numberOfOrderByCities($timePeriod);

}
