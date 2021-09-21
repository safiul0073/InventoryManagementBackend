<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ItemSale;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function checkId ($items, $id) {
        
        foreach ($items as $cat) {
            if ($cat->id == $id) {
                return $cat->name;
            }
        } 
    }

    public function getSelsItems ($items,$id) {
        $products = Product::all();
        $db_items = [];
        foreach($items as $item) {
            if ($item->invoice_id == $id) {
                $db_items[] = [
                    "product_name" => $this->checkId($products, $item->product_id),
                    "rate" => $item->rate,
                    "quantity" => $item->quantity,
                    "amount" => $item->amount,
                ];
            }
           
        }
        return $db_items;
    }

    public function index()
    {
        $productSales = ProductSale::latest()->get();
        $itemSells = ItemSale::all();

        foreach ($productSales as $sale) {
            $sells[] = [
                "invoice_no" => $sale->invoice_no,
                "name" => $sale->customer_name,
                "phone" => $sale->customer_phone,
                'amount' => $sale->total_amount,
                "items" => $this->getSelsItems($itemSells,$sale->invoice_no)
            ];
        }
        
        return response()->json(["sells" => $sells], 200);
    }



    public function store(Request $request)
    {
        // $product_sell = [];
        $ids = $request->products;
        $total_amount = 0;
        $products = Product::all();
        
            foreach($ids as $id) {
                foreach($products as $pro) {
                    if ($pro->id == $id) {
                        $total_amount += $pro->price;
                        $items = [
                            'invoice_id' => $request->invoiceNo,
                            'product_id' => $pro->id,
                            'rate' => "20%",
                            'quantity' => 1,
                            "amount" => $pro->price
                        ];
                        ItemSale::create($items);
                    }

                }
            }
       
        $product_sell = [
            'invoice_no' => $request->invoiceNo,
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'total_amount' => $total_amount,
        ];
         ProductSale::create($product_sell);


        return response()->json(["success" => true], 200);
    }


    public function show($id)
    {
        $category = ProductSale::findOrFail($id);
        return response()->json(["category" => $category], 200);
    }


    public function update(Request $request, $id)
    {
        ProductSale::findOrFail($id)->update(["name" => $request->name, "description" => $request->description]);
        return response()->json(["success" => true], 200);
    }


    public function destroy($id)
    {
        ProductSale::findOrFail($id)->delete();
        return response()->json(["success" => true], 200);
    }


    public function sellItems (Request $request) {
        $db_items = [];
        // $invoice_id = $request->id;

        $sellsItems = ItemSale::all();
        $products = Product::all();
        foreach($sellsItems as $item) {
            

                $db_items[] = [
                    "product_name" => $this->checkId($products, $item->product_id),
                    "rate" => $item->rate,
                    "quantity" => $item->quantity,
                    "amount" => $item->amount,
                    "invoice_id" => $item->invoice_id,
                ];
            
    
    }
    return response()->json(["sell_items" => $db_items]);
    }


    public function totalUser () {
        $total = User::count();
        return response()->json(["totalUser" => $total]);
    }
    public function totalOrder () {
        $total = ProductSale::count();
        return response()->json(["totalOrder" => $total]);
    }
    public function totalItems () {
        $total = Product::count();
        return response()->json(["totalProduct" => $total]);
    }
}
