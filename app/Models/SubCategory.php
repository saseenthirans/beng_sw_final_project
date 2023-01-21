<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function getCreator()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, 'id','category_id');
    }

    public function getSubCategoryLogs()
    {
        return $this->hasMany(SubCategoryLog::class, 'id', 'sub_category_id');
    }
}
