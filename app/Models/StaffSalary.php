<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory;

    public function staff()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
