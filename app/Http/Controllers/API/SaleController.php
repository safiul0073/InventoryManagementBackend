<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductSell;
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
        $productSales = ProductSale::with('itemsalse')->get();
        // $itemSells = ItemSale::with('itemsalse')->get();
        // dd($productSales);
        // foreach ($productSales as $sale) {
        //     $sells[] = [
        //         "invoice_no" => $sale->invoice_no,
        //         "name" => $sale->customer_name,
        //         "phone" => $sale->customer_phone,
        //         'amount' => $sale->total_amount,
        //         "items" => $this->getSelsItems($itemSells,$sale->invoice_no)
        //     ];
        // }
        
        return ProductSell::collection($productSales);
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_name' => 'required',
            'customer_phone' => 'required|max:256'
        ]);
        $items = (array) $request->pro;
        $total_amount = 0;

            foreach($items as $it) {
                $item =(array) $it;
                $total_amount += $item['price']*$item['qty'];
                    $hello = [
                        'invoice_id' => $request->invoiceNo,
                        'product_id' => $item['id'],
                        'rate' => "20%",
                        'quantity' => $item['qty'],
                        "amount" => $item['price'],
                    ];
                    ItemSale::create($hello);
                               
            }
       
        $product_sell = [
            'invoice_no' => $request->invoiceNo,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
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
