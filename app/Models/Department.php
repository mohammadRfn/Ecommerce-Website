<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use CrudTrait;
    public function category()
    {
        return $this->belongsTo(Category::class);  // Department belongs to one Category
    }
    protected $guarded = ['id'];
}
