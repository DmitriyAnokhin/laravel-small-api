<?php

namespace App\Models;

trait DemandMethods
{

    public function isExecutor()
    {
        $user = auth()->user();

        return $this->executor_id == $user->id ? true : false;
    }

    public function isIntermediary()
    {
        $user = auth()->user();

        return $this->intermediary_id == $user->id ? true : false;
    }

    public function isCompleted()
    {
        return $this->status == self::STATUS_COMPLETED ? true : false;
    }


    public function isOrderCustomer()
    {
        $user = auth()->user();

        return $this->order->customer_id == $user->id ? true : false;
    }

    public function isOrderCompleted()
    {
        $user = auth()->user();

        return $this->order->customer_id == $user->id ? true : false;
    }

    public static function demandAlreadyExists($orderId)
    {
        $user = auth()->user();

        return Demand::where([
            'order_id' => $orderId,
            'executor_id' => $user->id,
        ])->exists();
    }

}
