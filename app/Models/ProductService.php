<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductService extends Model
{
    use HasFactory;
    protected $fillable = [
        'auth_user_id',
        'service_user_id',
        'device_name',
        'issue_description',
        'price',
        'status',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_REPAIRED = 'repaired';
    public const STATUS_FINISHED = 'finished';


    public function authUser()
    {
        return $this->belongsTo(User::class, 'auth_user_id');
    }

    public function serviceUser()
    {
        return $this->belongsTo(User::class, 'service_user_id');
    }
}
