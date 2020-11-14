<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use OrderMethods;

    const STATUS_IN_SEARCH = 'IN_SEARCH';
    const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_CANCELED = 'CANCELED';

    const STATUSES = [
        self::STATUS_CANCELED,
        self::STATUS_COMPLETED,
    ];

    protected $dates = [
        'execution_date',
    ];

    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'execution_date',
        'percentage_intermediary',
        'status',
    ];


    public function customer()
    {
        return $this->belongsTo(User::class);
    }


    public function demands()
    {
        return $this->hasMany(Demand::class);
    }

}
