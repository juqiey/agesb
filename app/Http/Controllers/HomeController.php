<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        $months = collect(range(1,12))->map(function ($m){
           return Carbon::create()->month($m)->format('M');
        });

        $getMonthlyCount = function($table){
            return DB::table($table)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where('status', 'CLOSE')
                ->groupBy('month')
                ->pluck('total', 'month');
        };

        $ssrData = $getMonthlyCount('ssrs');
        $ssaData = $getMonthlyCount('ssas');
        $prData = $getMonthlyCount('purchase_requests');

        //Get Monthly DO total

        $doTotal = DeliveryOrder::get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->month;
            })
            ->map(function ($monthOrders) {
                return $monthOrders->sum('total');
            });


        // Normalize data to 12 months
        $normalize = function ($data) {
            return collect(range(1, 12))->map(fn($m) => $data[$m] ?? 0);
        };

        return view('dashboard', [
            'months' => $months,
            'ssr'=>$normalize($ssrData),
            'ssa'=>$normalize($ssaData),
            'pr'=>$normalize($prData),
            'do'=>$normalize($doTotal)
        ]);
    }
}
