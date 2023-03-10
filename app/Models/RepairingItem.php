<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairingItem extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->hasOne(Inventory::class,'id','product_id')->withTrashed();
    }
}
