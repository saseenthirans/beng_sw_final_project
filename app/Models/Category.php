<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public function getCreator()
    {
        return $this->hasOne(User::class, 'id','created_by');
    }

    public function getCategoryLogs()
    {
        return $this->hasMany(CategoryLog::class, 'id', 'category_id');
    }

    public function activeSubCategory()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id')->where('status',1);
    }
    
}
