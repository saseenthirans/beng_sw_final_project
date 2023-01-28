<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function purItems()
    {
        return $this->hasMany(PurchaseItem::class, 'pur_id','id');
    }

    public function purPayments()
    {
        return $this->hasMany(PurchasePayment::class, 'pur_id','id');
    }
}
