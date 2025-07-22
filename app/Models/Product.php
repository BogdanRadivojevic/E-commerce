<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'price', 'stock', 'image_path'];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    protected static function boot()
    {
        parent::boot();

        // Delete the associated image when the product is deleted
        static::deleting(function ($product) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
        });
    }

    public function imageUrl()
    {
        if ($this->image_path) {
            // if it’s already a full URL, return it as is
            if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
                return $this->image_path;
            }

            // otherwise assume it’s a file in storage
            return asset('storage/' . $this->image_path);
        }

        // fallback placeholder
        return asset('images/placeholder.jpg');
    }

}
