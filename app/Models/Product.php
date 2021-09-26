<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ["category_id", "unit_id", "name","price", "code","description","image","quantity","alert_quantity","status"];

    public function category () {
        return $this->belongsTo(Category::class);
    }
    public function unit () {
        return $this->belongsTo(Unit::class);
    }
    public function itemsalse () {
        return $this->belongsTo(ItemSale::class);
    }
}
