<?php

namespace App\Models;

trait OrderMethods
{

    public function isCompleted()
    {
        return $this->status == self::STATUS_COMPLETED ? true : false;
    }

    public static function isMyOrder($orderId)
    {
        $user = auth()->user();

        return Order::where([
            'id' => $orderId,
            'customer_id' => $user->id,
        ])->exists();
    }

}
