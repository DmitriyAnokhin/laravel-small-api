<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Exception;

class OrderController extends Controller
{

    public function create(OrderRequest $request)
    {
        $user = auth()->user();

        $order = Order::create(array_merge(
            $request->validated(),
            ['customer_id' => $user->id],
        ));

        return new JsonResource($order);
    }


    public function list()
    {
        return JsonResource::collection(Order::all());
    }


    public function read(OrderRequest $request, $id)
    {
        $order = Order::find($id);

        return new JsonResource($order);
    }


    public function canceled(OrderRequest $request, $id)
    {
        $order = Order::find($id);

        if ($order->isCompleted()) {

            throw new Exception('Заказ уже выполнен', 409);
        }

        $order->status = Order::STATUS_CANCELED;
        $order->save();

        return new JsonResource($order);
    }


    public function completed(OrderRequest $request, $id)
    {
        $order = Order::find($id);
        $order->status = Order::STATUS_COMPLETED;
        $order->save();

        return new JsonResource($order);
    }

}
