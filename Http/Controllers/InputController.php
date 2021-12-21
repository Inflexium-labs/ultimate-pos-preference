<?php

namespace Modules\Preference\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Preference\Entities\HideInput;
use Yajra\DataTables\Facades\DataTables;

class InputController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $collection = [];
        $inputs = DB::table('hide_inputs')->join('business', 'business.id', '=', 'hide_inputs.business_id')
            ->select('hide_inputs.*', 'business.name as business_name')
            ->get();

        foreach ($inputs as $key => $input) {
            $collection[] = [
                'id' => $input->id,
                'business' => $input->business_name,
                'module' => $input->module_name,
                'input' => $input->input_name,
            ];
        }
        $collection = collect($collection);

        return DataTables::collection($collection)->make(true);
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
        $input = HideInput::updateOrCreate([
            'business_id' => $request->business,
            'module_name' => $request->module,
            'input_name' => $request->input,
        ], [
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'msg' => __("Input hide successfully for the business!")
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('preference::show');
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
        $input = HideInput::findOrFail($id);

        if ($input->delete())
            return response()->json([
                'status' => true,
                'msg' => 'Input visible again!'
            ]);

        return response()->json([
            'status' => false,
            'msg' => 'Something went wrong!'
        ]);
    }

    /**
     * Get hidable input list
     * @param mixed $module
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInputs($module)
    {
        //Product list columns
        if ($module == 'Products')
            $columns = [
                'Brand',
                'Tax Inputs',
            ];

        return response()->json([
            'data' => $columns ?? []
        ]);
    }
}
