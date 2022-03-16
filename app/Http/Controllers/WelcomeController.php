<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function vehiclesAjax(Request $request)
    {
        if($request->ajax()) {
            $model = Vehicle::with('property');
            return DataTables::eloquent($model)
                ->filter(function ($query) use ($request){
                    if (request()->has('make')) {
                        $query->where('make', 'like', "%" . request('make') . "%");
                    }
                    if (request()->has('model')) {
                        $query->where('model', 'like', "%" . request('model') . "%");
                    }
                    if (request()->has('property')) {
                        $query->whereHas('property', function ($query) use ($request){
                            $query->where('name', 'like', '%'. $request->property .'%');
                        });
                    }
                })
                ->toJson();
        }
    }
}
