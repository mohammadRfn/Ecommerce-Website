<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use CrudTrait;
    protected $fillable = [
        'title', 'slug', 'description', 'department_id', 'category_id',
        'quantity', 'price', 'status', 'created_by', 'updated_by'
    ];
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Automatically assign created_by and updated_by before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->created_by = backpack_auth()->id();
            $product->updated_by = backpack_auth()->id();
        });

        static::updating(function ($product) {
            $product->updated_by = backpack_auth()->id();
        });
    }
}
