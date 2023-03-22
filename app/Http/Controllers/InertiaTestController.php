<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InertiaTest;
use App\Http\Requests\InertiaFormRequest;

class InertiaTestController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Inertia/Index');
    }
    public function create()
    {
        return Inertia::render('Inertia/Create');
    }
    public function show($id)
    {
        return Inertia::render(
            'Inertia/Show',
            [
                'id' => $id
            ]
        );
    }

    public function store(InertiaFormRequest $request,InertiaTest $inertiaTest){


        $inertiaTest->fill($request->all());
        $inertiaTest->save();

        return to_route('inertia.index')
        ->with([
            'message'=>'登録しました',
        ]);
    }
}
