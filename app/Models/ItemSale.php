<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSale extends Model
{
    use HasFactory;
    protected $fillable = ["invoice_id", "product_id", "rate", "quantity", "amount"];

    public function productsales () {
        return $this->belongsTo(ProductSale::class, "invoice_no", "invoice_id");
    }

    public function products () {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
