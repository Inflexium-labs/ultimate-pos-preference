<?php

namespace Modules\Preference\Http\Controllers;

use App\System;
use App\Business;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;
use Modules\Preference\Entities\HideColumn;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $modules = [
            'Products'
        ];

        $businesses = Business::all()->pluck('name', 'id');

        if ($request->ajax()) {
            $collection = [];
            $columns = DB::table('hide_columns')->join('business', 'business.id', '=', 'hide_columns.business_id')
                ->select('hide_columns.*', 'business.name as business_name')
                ->get();

            foreach ($columns as $key => $col) {
                $collection[] = [
                    'id' => $col->id,
                    'business' => $col->business_name,
                    'module' => $col->module_name,
                    'column' => $col->column_name,
                ];
            }
            $collection = collect($collection);

            return DataTables::collection($collection)->make(true);
        }

        return view('preference::index', compact('modules', 'businesses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('preference::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        $column = HideColumn::updateOrCreate([
            'business_id' => $request->business,
            'module_name' => $request->module,
            'column_name' => $request->column,
        ], [
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'msg' => __("Column hide successfully for the business!")
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        // return view('preference::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('preference::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $column = HideColumn::findOrFail($id);

        if ($column->delete())
            return response()->json([
                'status' => true,
                'msg' => 'Column visible again!'
            ]);

        return response()->json([
            'status' => false,
            'msg' => 'Something went wrong!'
        ]);
    }

    public function getColumns($module)
    {
        if ($module == 'Products')
            $columns = [
                'Selling Price',
                'Brand',
                'Tax',
                'Custom Field3',
                'Custom Field4'
            ];

        return response()->json([
            'data' => $columns ?? []
        ]);
    }
}
