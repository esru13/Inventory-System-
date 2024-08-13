<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'business_owner_id',
    ];

    public function businessOwner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
