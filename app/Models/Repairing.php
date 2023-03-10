<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repairing extends Model
{
    use HasFactory, SoftDeletes;

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id')->withTrashed();
    }

    public function category()
    {
        return $this->hasOne(RepairCategory::class,'id','category_id')->withTrashed();
    }

    public function creator()
    {
        return $this->hasOne(User::class,'id','user_id')->withTrashed();
    }

    public function repairItems()
    {
        return $this->hasMany(RepairingItem::class, 'repairing_id', 'id');
    }
}
