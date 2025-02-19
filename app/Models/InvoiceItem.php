<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->hasOne(Inventory::class,'id','product_id');
    }
}
