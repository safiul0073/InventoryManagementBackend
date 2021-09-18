<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Http\Request;
class ProductObserver
{
    public function creating(Product $product)
    {
        
        if($product->image){
            $image = $product->image;
            $imagename = time().'_'.uniqid().'.'.$product->image->getClientOriginalExtension();
            $imagepublicpath = public_path('storage/image');
            $image->move($imagepublicpath, $imagename);
            $imagepath = '/storage/image/'.$imagename;
            $product->image = $imagepath;
        }
        
    }
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {

    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
