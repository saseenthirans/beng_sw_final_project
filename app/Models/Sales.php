<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use HasFactory, SoftDeletes;

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'id', 'inv_id');
    }
    
}
