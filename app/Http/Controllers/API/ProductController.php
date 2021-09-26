<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Carbon\Carbon;
use File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    
    public function index()
    {
        $products = Product::latest()->get();

        return ProductCollection::collection($products);
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
