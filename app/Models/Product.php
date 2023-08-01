<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;

class Product extends Model
{

    protected $fillable = ['category_id', 'title', 'desc', 'price', 'stock'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function productImage(){
        return $this->hasMany(ProductImage::class);
    }

    public function productVariant()
    {
        return $this->hasMany(ProductVariant::class);
    }


    use HasFactory;
}

