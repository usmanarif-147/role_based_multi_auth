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

        /**
         * Important Link for show and hide columns
         * https://makitweb.com/dynamically-show-hide-columns-in-datatable-ajax-pagination/
        */

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
                ->order(function ($query) {
                    if (request()->has('sort')) {
                        if(request('sort') == 'make')
                        $query->orderBy('make', 'asc');
                    }
                })
                ->toJson();
        }
    }
}
