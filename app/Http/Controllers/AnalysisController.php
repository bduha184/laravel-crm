<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalysisRequest;
use App\Http\Requests\UpdateAnalysisRequest;
use App\Models\Analysis;
use App\Models\Order;
use Inertia\Inertia;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $startDate="2022-08-01";
        $endDate="2022-08-31";

        $period = Order::betweenDate($startDate,$endDate)
        ->groupBy('id')
        ->selectRaw('id,sum(subtotal) as total,customer_name,status,created_at')
        ->orderBy('created_at')
        ->paginate(50);

        return Inertia::render('Analysis',[
            'period' => $period,
        ]);
    }

}
