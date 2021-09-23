<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ["category_id", "unit_id", "name","price", "code","description","image","quantity","alert_quantity","status"];

    public function categorys () {
        return $this->belongsTo(Category::class);
    }
    public function units () {
        return $this->belongsTo(Unit::class);
    }
    public function itemsalse () {
        return $this->belongsTo(ItemSale::class);
    }
}
