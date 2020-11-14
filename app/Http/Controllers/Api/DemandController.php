<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemandRequest;
use App\Models\Demand;
use App\Models\Order;
use Exception;

class DemandController extends Controller
{

    public function create(DemandRequest $request, $orderId)
    {
        $user = auth()->user();

        // это заказчик
        if (Order::isMyOrder($orderId)) {

            throw new Exception('Создатель заказа не может разместить заявку', 409);
        }

        // дубль заявки
        if (Demand::demandAlreadyExists($orderId)) {

            throw new Exception('Заявка уже создана', 409);
        }

        $demand = Demand::create(array_merge(
            $request->validated(),
            ['executor_id' => $user->id],
        ));

        return new JsonResource($demand);
    }


    public function list(DemandRequest $request, $orderId)
    {
        $order = Order::find($orderId);

        return JsonResource::collection($order->demands);
    }


    // принять заявку может посредник
    public function accept(DemandRequest $request, $orderId, $id)
    {
        $demand = Demand::find($id);

        if ($demand->order_id != $orderId) {

            throw new Exception('Заявка не принадлежит заказу', 409);
        }

        // это исполнитель
        if ($demand->isExecutor()) {

            throw new Exception('Исполнитель не может принять заявку', 409);
        }

        // это заказчик
        if ($demand->isOrderCustomer()) {

            throw new Exception('Создатель заказа не может принять заявку', 409);
        }

        $user = auth()->user();

        try {
            DB::beginTransaction();

            $demand->status = Demand::STATUS_IN_PROGRESS;
            $demand->intermediary_id = $user->id; // посредник
            $demand->save();

            $demand->order()->update([
                'status' => Order::STATUS_IN_PROGRESS,
            ]);

            DB::commit();

        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return new JsonResource($demand);
    }


    // отменить заявку может исполнитель
    public function canceled(DemandRequest $request, $orderId, $id)
    {
        $demand = Demand::find($id);

        $user = auth()->user();

        if ($demand->executor_id != $user->id) {

            throw new Exception('Пользователь не является исполнителем заявки', 409);
        }

        if ($demand->status == Demand::STATUS_COMPLETED) {

            throw new Exception('Заявка уже выполнена', 409);
        }

        $demand->status = Demand::STATUS_CANCELED;
        $demand->save();

        return new JsonResource($demand);
    }

}
