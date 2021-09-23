<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Carbon\Carbon;
use File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function checkId ($items, $id) {
        
        foreach ($items as $cat) {
            if ($cat->id == $id) {
                return $cat->name;
            }
        } 
    }
    
    public function index()
    {
        $categorys = Category::all();
        $units = Unit::all();
        $db_products = [];
        $products = Product::latest()->get();
        foreach ($products as $pro) {

            $db_products[] = [
                "id" => $pro->id,
                "name" => $pro->name,
                "image" => $pro->image,
                'category_id' => $pro->category_id,
                'unit_id' => $pro->unit_id,
                "category" => $this->checkId($categorys, $pro->category_id),
                "unit" => $this->checkId($units, $pro->unit_id),
                "description" => $pro->description,
                "code" => $pro->code,
                "price" => $pro->price,
                "quantity" => $pro->quantity,
                "alert_quantity" => $pro->alert_quantity,
                "status" => $pro->status
            ];
        }
        return response()->json(["products" => $db_products], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:256, min:2',
            'code'    => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'alert_quantity' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        Product::create($request->all());

        return response()->json(["success" => true], 200);
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(["product" => $product], 200);
    }


    public function update(Request $request, $id)
    {
        
        $product = Product::findOrFail($id);
        $imagepath = null;
        if($request->hasFile('image')){
            $image = $request->image;
            $imagename = time().'_'.uniqid().'.'.$request->image->getClientOriginalExtension();
            $imagepublicpath = public_path('storage/image');
            $image->move($imagepublicpath, $imagename);
            if(File::exists($product->image)){
                unlink($product->image);
            }
            $imagepath = '/storage/image/'.$imagename;
        }
        if($imagepath == null){
            $imagepath = $product->image;
        }

        $attributes = [
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'image' => $imagepath,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'alert_quantity' => $request->alert_quantity,
            'status' => $request->status,
        ];
        $product->update($attributes);
        return response()->json(["success" => true], 200);
    }


    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(["success" => true], 200);
    }
}
