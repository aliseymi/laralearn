<?php

namespace Modules\Discount\Entities;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'percent',
        'user',
        'expired_at'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    protected static function newFactory()
    {
        return \Modules\Discount\Database\factories\DiscountFactory::new();
    }
}
