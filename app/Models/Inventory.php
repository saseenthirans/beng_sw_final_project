<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    //This is based on Subcategory
    public function category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'category_id');
    }

    public function inventoryImage()
    {
        return $this->hasMany(InventoryImage::class,'inv_id','id');
    }

    public function saleItem()
    {
        return $this->hasOne(Sales::class,'inv_id','id')->where('status',1);
    }
}
