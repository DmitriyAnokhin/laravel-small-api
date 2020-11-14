<?php

namespace App\Models;

trait UserMethods
{

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public static function emailExists($email)
    {
        return User::where('email', $email)->exists();
    }

    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    public function averageRating()
    {
        return round($this->reviews()->avg('reviews.rating'), 1);
    }

}
