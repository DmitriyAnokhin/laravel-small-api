<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    use DemandMethods;

    const STATUS_IN_SEARCH = 'IN_SEARCH';
    const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_CANCELED = 'CANCELED';

    protected $fillable = [
        'order_id',
        'executor_id',
        'intermediary_id',
        'status',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_id');
    }

    public function intermediary()
    {
        return $this->belongsTo(User::class, 'intermediary_id');
    }

}
