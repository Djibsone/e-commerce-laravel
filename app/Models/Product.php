<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['stock'];
    
    public function getPrice()
    {
        $price = $this->price;
        return number_format($price, 2, ',', ' ') . ' XOF';
    }

    public function getSlug()
    {
        return Str::slug($this->title);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
