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

        $subQuery = Order::betweenDate($startDate, $endDate)
        ->where('status', true)
        ->groupBy('id')
        ->selectRaw('id, SUM(subtotal) as totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") as date');

        $data = DB::table($subQuery)
        ->groupBy('date')
        ->selectRaw('date, sum(totalPerPurchase) as total')
        ->get();


        return Inertia::render('Analysis');
    }

}
