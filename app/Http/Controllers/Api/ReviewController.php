<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Demand;
use App\Models\Review;
use App\Models\User;
use Exception;

class ReviewController extends Controller
{

    public function create(ReviewRequest $request, $demandId)
    {
        $demand = Demand::find($demandId);

        $user = auth()->user();

        // оставить отзыв может только посредник
        if (!$demand->isIntermediary()) {

            throw new Exception('Отзыв может оставить только посредник', 409);
        }

        if (!$demand->isCompleted()) {

            throw new Exception('Заявка еще не выполнена', 409);
        }

        $review = Review::create(array_merge(
            $request->validated(),
            ['demand_id' => $demand->id],
        ));

        return new JsonResource($review);
    }


    public function list(ReviewRequest $request, $userId)
    {
        $user = User::find($userId);

        return JsonResource::collection($user->reviews);
    }

}
