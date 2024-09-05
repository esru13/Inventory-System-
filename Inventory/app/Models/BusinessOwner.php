<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class BusinessOwner extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name'
    ];

    protected $hidden = [
        'password',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'business_owner_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function businessOwner()
    {
        return $this->hasOne(BusinessOwner::class);
    }

}