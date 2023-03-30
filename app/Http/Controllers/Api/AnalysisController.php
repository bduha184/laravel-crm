<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AnalysisServices;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AnalysisController extends Controller
{

    public function index(Request $request)
    {

        $subQuery = Order::betweenDate($request->startDate, $request->endDate);
        if ($request->type === 'perDay') {
            list($data,$labels,$totals)=AnalysisServices::perDay($subQuery);
        }
        if ($request->type === 'perMonth') {
            list($data,$labels,$totals)=AnalysisServices::perMonth($subQuery);
        }
        if ($request->type === 'perYear') {
            list($data,$labels,$totals)=AnalysisServices::perYear($subQuery);
        }

        return response()->json([
            'data'=>$data,
            'type'=>$request->type,
            'labels' => $labels,
            'totals' => $totals
        ], Response::HTTP_OK);
    }
}
