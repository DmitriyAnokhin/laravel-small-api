<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use DB;

class ProfileController extends Controller
{

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        return new JsonResource($user);
    }


    public function read()
    {
        $user = auth()->user();

        $user->total_reviews = $user->totalReviews();
        $user->average_rating = $user->averageRating();

        return new JsonResource($user);
    }

}
