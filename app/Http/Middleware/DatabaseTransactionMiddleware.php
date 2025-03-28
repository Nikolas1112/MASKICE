<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DatabaseTransactionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Start the transaction
        DB::beginTransaction();

        try {
            // Proceed to the next middleware/request handler
            $response = $next($request);

            // If no errors, commit the transaction
            DB::commit();

            return $response;
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // You can log the error or return a custom error message
            return response()->json([
                'error' => 'An error occurred. Transaction rolled back.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
