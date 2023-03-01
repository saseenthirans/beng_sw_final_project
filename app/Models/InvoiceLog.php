<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLog extends Model
{
    use HasFactory;

    public function getCreator()
    {
        return $this->hasOne(User::class, 'id','user_id')->withTrashed();
    }
}
