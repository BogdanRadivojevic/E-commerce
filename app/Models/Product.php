<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'price', 'stock', 'image_path'];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
