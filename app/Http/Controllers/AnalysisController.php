<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalysisRequest;
use App\Http\Requests\UpdateAnalysisRequest;
use App\Models\Analysis;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $startDate = "2022-08-01";
        $endDate = "2022-08-31";

        // $subQuery = Order::betweenDate($startDate, $endDate)
        // ->where('status', true)
        // ->groupBy('id')
        // ->selectRaw('id, SUM(subtotal) as totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") as date');

        // $data = DB::table($subQuery)
        // ->groupBy('date')
        // ->selectRaw('date, sum(totalPerPurchase) as total')
        // ->get();

        $subQuery = Order::betweenDate($startDate,$endDate)
        ->groupBy('id')
        ->selectRaw('id,customer_id,customer_name,sum(subtotal) as totalPerPurchase');

        $subQuery = DB::table($subQuery)
        ->groupBy('customer_id')
        ->selectRaw('customer_id,customer_name,sum(totalPerPurchase) as total')
        ->orderBy('total','desc');

        DB::statement('set @row_num = 0;');
            $subQuery = DB::table($subQuery)
            ->selectRaw('
                @row_num := @row_num+1 as row_num,
                customer_id,
                customer_name,
                total
            ');

        $count = DB::table($subQuery)->count();
        $total = DB::table($subQuery)->selectRaw('sum(total) as total')->get();
        $total = $total[0]->total;

        $decile = ceil($count/10);

        $bindValues = [];
        $tempValue=0;
        for($i = 1;$i<=10;$i++)
        {
            array_push($bindValues,1+$tempValue);
            $tempValue += $decile;
            array_push($bindValues,1+$tempValue);
        }

        dd($count,$decile,$bindValues);

        // return Inertia::render('Analysis');
    }

}
