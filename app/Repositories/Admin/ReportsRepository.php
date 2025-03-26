<?php

namespace App\Repositories\Admin;

use App\Models\CommissionHistory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Search;
use App\Models\Wallet;
use App\Models\Wishlist;
use App\Repositories\Interfaces\Admin\ReportsInterface;
use Carbon\Carbon;
use Sentinel;
use DB;

class ReportsRepository implements ReportsInterface
{

    public function stockProduct($request, $limit)
    {
        $start_date = null;
        $end_date = null;

        if ($request->time_period != null) {
            $dates = explode(' - ', $request->time_period);
            $start_date = Carbon::createFromFormat('m-d-Y g:ia', $dates[0]);
            $end_date = Carbon::createFromFormat('m-d-Y g:ia', $dates[1]);

        }

        return Product::when($request->time_period != null, function ($query) use ($start_date, $end_date) {
                $query->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);
            })
            ->when($request->c != null, function ($query) use ($request) {
                $query->where('category_id', $request->c);
            })
            ->when(Sentinel::getUser()->user_type == 'seller', function ($query) {
                $query->where('user_id', Sentinel::getUser()->id);
            })->CheckSellerSystem()
            ->paginate($limit);
    }

    public function product($request, $limit, $for = null)
    {
        $start_date = null;
        $end_date = null;
        if ($request->dt != null):
            $dates = explode(" - ", $request->dt);
            $start_date = Carbon::createFromFormat('m-d-Y g:ia', $dates[0]);
            $end_date = Carbon::createFromFormat('m-d-Y g:ia', $dates[1]);
        endif;

        $product = Product::with('category')->CheckSellerSystem()
            ->when($for != null, function ($query) use ($for, $request) {
                $query->when($for == 'for_admin', function ($q) {
                    $q->where('user_id', 1);
                });
                $query->when($for == 'for_seller', function ($sellerQ) use ($request) {
                    $sellerQ->where('user_id', '!=', 1);
                    $sellerQ->when($request->sl != null, function ($qu) use ($request) {
                        $qu->whereHas('sellerProfile', function ($query) use ($request) {
                            $query->where('id', $request->sl);
                        });
                    });
                });
            })
            ->when(Sentinel::getUser()->user_type != null, function ($query) use ($request) {
                $query->when(Sentinel::getUser()->user_type == 'seller', function ($sellerQ) use ($request) {
                    $sellerQ->where('user_id', Sentinel::getUser()->id);
                });
            })
            ->when($request->c != null, function ($query) use ($request) {
                $query->where('category_id', $request->c);
            })
            ->when($request->dt != null, function ($query) use ($start_date, $end_date) {
                $query->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);
            })
            ->whereHas('orders.order', function ($q){
                $q->where('delivery_status', 'delivered');
            })
            ->withsum('orders', 'quantity')
            ->withsum('orders', 'price')
            ->paginate($limit);
        return $product;
    }

    public function commissionHistory($request, $limit)
    {
        $start_date     = null;
        $end_date       = null;

        if ($request->dt != null):
            $dates      = explode(" - ", $request->dt);
            $start_date = Carbon::createFromFormat('m-d-Y g:ia', $dates[0]);
            $end_date   = Carbon::createFromFormat('m-d-Y g:ia', $dates[1]);
        endif;

        $commissions = CommissionHistory::when($request->s != null, function ($query) use ($request) {
            $query->where('seller_id', $request->s);
        })->when($request->dt != null, function ($query) use ($start_date, $end_date) {
            $query->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        })->when(Sentinel::getUser()->user_type == 'seller', function ($query) use ($request) {
            $query->where('seller_id', Sentinel::getUser()->id);
        })->paginate($limit);

        return $commissions;
    }

    public function wishlist($request, $limit)
    {
        $wishlist = Wishlist::when($request->c != null, function ($query) use ($request) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('products.category_id', $request->c);
            });
        })
            ->when($request->q != null, function ($query) use ($request) {
                $query->whereHas('product.productLanguages', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->q . '%');
                });
            })
            ->when(Sentinel::getUser()->user_type == 'seller', function ($query) use ($request) {
                $query->whereHas('product.user', function ($q) use ($request) {
                    $q->where('id', Sentinel::getUser()->id);

                });
            })
            ->select(
                DB::raw("(count(user_id)) as total_wish"),
                DB::raw("product_id")
            )
            ->orderBy('product_id')
            ->groupBy(DB::raw("product_id"))
            ->paginate($limit);

        return $wishlist;
    }

    public function searches($request, $limit)
    {
        // TODO: Implement searches() method.
        $wishlist = Search::when($request->q != null, function ($query) use ($request) {
            $query->where('query', 'like', '%' . $request->q . '%');
        })->orderBy('total_search', 'DESC')->paginate($limit);

        return $wishlist;
    }

    public function walletRechargeHistory($request, $limit)
    {
        // TODO: Implement walletRechargeHistory() method.

        $start_date = null;
        $end_date = null;
        if ($request->dt != null):
            $dates = explode(" - ", $request->dt);
            $start_date = Carbon::createFromFormat('m-d-Y g:ia', $dates[0]);
            $end_date = Carbon::createFromFormat('m-d-Y g:ia', $dates[1]);
        endif;

        return Wallet::when($request->u != null, function ($query) use ($request) {
            $query->where('user_id', $request->u);
        })
            ->when($request->dt != null, function ($query) use ($request) {
                $query->where('user_id', $request->u);
            })
            ->when($request->dt != null, function ($query) use ($start_date, $end_date) {
                $query->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);
            })
            ->where('source','wallet_recharge')
            ->latest()
            ->paginate($limit);
    }



    public function totalOrderCount($timePeriod){

        switch($timePeriod){
            case 'today':
                $orders = Order::whereDate('date', Carbon::today()->toDateString())->get(); // Orders placed today
                break;
        
            case 'yesterday':
                $orders = Order::whereDate('date', Carbon::yesterday()->toDateString())->get(); // Orders placed yesterday
                break;
        
            case 'last_seven_days':
                $orders = Order::where('date', '>=', Carbon::now()->subDays(7)->toDateString())->get(); // Orders placed in the last 7 days
                break;
        
            case 'this_month':
                // For Orders in This Month
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfMonth()->toDateString())->get();
                break;
        
            case 'last_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth()->toDateString()) // First day of last month
                                ->where('created_at', '<', Carbon::now()->startOfMonth()->toDateString()) // Before this month starts
                                ->get();
                break;
        
            case 'yearly':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfYear()->toDateString())->get();
                break;
        
            default:
                $orders = Order::all(); // Get all orders if no valid time period is provided
                break;
        }
        
        return (!empty($orders)) ? count($orders) : 0;
    }




    public function totalAmountOfOrder($timePeriod){

        switch($timePeriod){
            case 'today':
                $orders = Order::whereDate('date', Carbon::today()->toDateString())->get(); // Orders placed today
                break;
        
            case 'yesterday':
                $orders = Order::whereDate('date', Carbon::yesterday()->toDateString())->get(); // Orders placed yesterday
                break;
        
            case 'last_seven_days':
                $orders = Order::where('date', '>=', Carbon::now()->subDays(7)->toDateString())->get(); // Orders placed in the last 7 days
                break;
        
            case 'this_month':
                // For Orders in This Month
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfMonth()->toDateString())->get();
                break;
        
            case 'last_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth()->toDateString()) // First day of last month
                                ->where('created_at', '<', Carbon::now()->startOfMonth()->toDateString()) // Before this month starts
                                ->get();
                break;
        
            case 'yearly':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfYear()->toDateString())->get();
                break;
        
            default:
                $orders = Order::all(); // Get all orders if no valid time period is provided
                break;
        }

        // Sum the total_payable_amount for all orders
        $totalAmount = $orders->sum('total_payable');

        return $totalAmount;
    }



    public function totalOrderWithFees($timePeriod)
    {
        switch ($timePeriod) {
            case 'today':
                $orders = Order::whereDate('date', Carbon::today()->toDateString())
                               ->where('total_tax', '>', 0) // Filter orders with non-zero tax
                               ->get(); // Orders placed today
                break;
    
            case 'yesterday':
                $orders = Order::whereDate('date', Carbon::yesterday()->toDateString())
                               ->where('total_tax', '>', 0) // Orders placed yesterday with non-zero tax
                               ->get();
                break;
    
            case 'last_seven_days':
                $orders = Order::where('date', '>=', Carbon::now()->subDays(7)->toDateString())
                               ->where('total_tax', '>', 0) // Orders placed in the last 7 days with non-zero tax
                               ->get();
                break;
    
            case 'this_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfMonth()->toDateString())
                               ->where('total_tax', '>', 0) // Orders in this month with non-zero tax
                               ->get();
                break;
    
            case 'last_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth()->toDateString()) // First day of last month
                               ->where('created_at', '<', Carbon::now()->startOfMonth()->toDateString()) // Before this month starts
                               ->where('total_tax', '>', 0) // Orders from last month with non-zero tax
                               ->get();
                break;
    
            case 'yearly':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfYear()->toDateString())
                               ->where('total_tax', '>', 0) // Orders from this year with non-zero tax
                               ->get();
                break;
    
            default:
                $orders = Order::where('total_tax', '>', 0) // Default case: filter orders with non-zero tax
                               ->get();
                break;
        }
    
        $totalOrderWithFees = (!empty($orders)) ? count($orders) : 0;
    
        return $totalOrderWithFees;
    }
    

    public function totalOrderWithoutFees($timePeriod)
    {
        switch ($timePeriod) {
            case 'today':
                $orders = Order::whereDate('date', Carbon::today()->toDateString())
                               ->where('total_tax', '=', 0) // Filter orders with non-zero tax
                               ->get(); // Orders placed today
                break;
    
            case 'yesterday':
                $orders = Order::whereDate('date', Carbon::yesterday()->toDateString())
                               ->where('total_tax', '=', 0) // Orders placed yesterday with non-zero tax
                               ->get();
                break;
    
            case 'last_seven_days':
                $orders = Order::where('date', '>=', Carbon::now()->subDays(7)->toDateString())
                               ->where('total_tax', '=', 0) // Orders placed in the last 7 days with non-zero tax
                               ->get();
                break;
    
            case 'this_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfMonth()->toDateString())
                               ->where('total_tax', '=', 0) // Orders in this month with non-zero tax
                               ->get();
                break;
    
            case 'last_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth()->toDateString()) // First day of last month
                               ->where('created_at', '<', Carbon::now()->startOfMonth()->toDateString()) // Before this month starts
                               ->where('total_tax', '=', 0) // Orders from last month with non-zero tax
                               ->get();
                break;
    
            case 'yearly':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfYear()->toDateString())
                               ->where('total_tax', '=', 0) // Orders from this year with non-zero tax
                               ->get();
                break;
    
            default:
                $orders = Order::where('total_tax', '=', 0) // Default case: filter orders with non-zero tax
                               ->get();
                break;
        }
    
        $totalOrderWithoutFees = (!empty($orders)) ? count($orders) : 0;
    
        return $totalOrderWithoutFees;
    }


    public function averageOrdersPerDay($timePeriod) {
        // Initialize the number of days to divide by
        $days = 1; // Default to 1 day for 'today' and 'yesterday'
    
        // Get the orders based on the selected time period
        switch ($timePeriod) {
            case 'today':
                $orders = Order::whereDate('date', Carbon::today()->toDateString())->get();
                $days = 1; // 1 day for today
                break;
    
            case 'yesterday':
                $orders = Order::whereDate('date', Carbon::yesterday()->toDateString())->get();
                $days = 1; // 1 day for yesterday
                break;
    
            case 'last_seven_days':
                $orders = Order::where('date', '>=', Carbon::now()->subDays(7)->toDateString())->get();
                $days = 7; // 7 days for last 7 days
                break;
    
            case 'this_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfMonth()->toDateString())->get();
                $days = Carbon::now()->daysInMonth; // Days in current month
                break;
    
            case 'last_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth()->toDateString())
                    ->where('created_at', '<', Carbon::now()->startOfMonth()->toDateString())->get();
                $days = Carbon::now()->subMonth()->daysInMonth; // Days in last month
                break;
    
            case 'yearly':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfYear()->toDateString())->get();
                $days = Carbon::now()->dayOfYear; // Days passed in this year
                break;
    
            default:
                $orders = Order::all(); // Get all orders if no valid time period is provided
                $days = 1; // Default to 1 day
                break;
        }
    
        // Calculate the total number of orders
        $totalOrders = $orders->count();
    
        // Calculate average orders per day
        $averageOrdersPerDay = $days > 0 ? $totalOrders / $days : 0;
    
        return number_format($averageOrdersPerDay,"2",'.');
    }


    public function numberOfOrderByCities($timePeriod){
        switch($timePeriod){
            case 'today':
                $orders = Order::whereDate('date', Carbon::today()->toDateString())->get(); // Orders placed today
                break;
        
            case 'yesterday':
                $orders = Order::whereDate('date', Carbon::yesterday()->toDateString())->get(); // Orders placed yesterday
                break;
        
            case 'last_seven_days':
                $orders = Order::where('date', '>=', Carbon::now()->subDays(7)->toDateString())->get(); // Orders placed in the last 7 days
                break;
        
            case 'this_month':
                // For Orders in This Month
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfMonth()->toDateString())->get();
                break;
        
            case 'last_month':
                $orders = Order::where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth()->toDateString()) // First day of last month
                                ->where('created_at', '<', Carbon::now()->startOfMonth()->toDateString()) // Before this month starts
                                ->get();
                break;
        
            case 'yearly':
                $orders = Order::where('created_at', '>=', Carbon::now()->startOfYear()->toDateString())->get();
                break;
        
            default:
                $orders = Order::all(); // Get all orders if no valid time period is provided
                break;
        }


        // Extracting city from the shipping address and counting orders by city
        $ordersGroupedByCity = $orders->groupBy(function($order) {
        return $order->shipping_address['city']; // Assuming the shipping address is stored as a JSON field
        });

        // Counting the number of orders per city
        $ordersCountByCity = $ordersGroupedByCity->map(function($ordersInCity) {
            return $ordersInCity->count(); // Get the count of orders in each city
        });

        // Prepare the data for the chart
        $cities = $ordersCountByCity->keys()->toArray();
        $orderCounts = $ordersCountByCity->values()->toArray();

        // dd($cities,$orderCounts);

        return ['cities' => $cities,'orderCounts' => $orderCounts];

    }
    
}
