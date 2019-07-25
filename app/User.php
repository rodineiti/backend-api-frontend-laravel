<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'admin'
    ];

    /**
     * User has many .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthAccessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }

    /**
     * User has many .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany(Category::class);
    }

    /**
     * User has many .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bill_receives()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany(BillReceive::class);
    }

    /**
     * User has many .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bill_pays()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany(BillPay::class);
    }
}
