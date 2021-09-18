<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSale extends Model
{
    use HasFactory;
    protected $fillable = ["invoice_id", "product_id", "rate", "quantity", "amount"];
}
