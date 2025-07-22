<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status'];

    const STATUS_COMPLETED = 'completed';
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    // Proverava da li je narudžbina aktivna (korpa)
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Proverava da li je narudžbina završena
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
