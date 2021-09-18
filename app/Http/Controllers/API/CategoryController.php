<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::latest()->get();
        
        return response()->json(["categorys" => $categorys], 200);
    }


    public function store(Request $request)
    {
        Category::create($request->all());
        return response()->json(["success" => true], 200);
    }


    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(["category" => $category], 200);
    }


    public function update(Request $request, $id)
    {
        Category::findOrFail($id)->update(["name" => $request->name, "description" => $request->description]);
        return response()->json(["success" => true], 200);
    }


    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(["success" => true], 200);
    }
}
