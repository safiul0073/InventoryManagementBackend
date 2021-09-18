<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->get();
        
        return response()->json(["units" => $units], 200);
    }


    public function store(Request $request)
    {
        Unit::create($request->all());
        return response()->json(["success" => true], 200);
    }


    public function show($id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json(["unit" => $unit], 200);
    }


    public function update(Request $request, $id)
    {
        Unit::findOrFail($id)->update(["name" => $request->name, "code" => $request->code]);
        return response()->json(["success" => true], 200);
    }


    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();
        return response()->json(["success" => true], 200);
    }
}
