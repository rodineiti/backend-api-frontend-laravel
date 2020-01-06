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
        'name', 'email', 'password', 'image'
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
  
    /**
     * User has many .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany(Content::class);
    }
  
    /**
     * User has many .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany(Comment::class);
    }
  
    /**
     * User belongsToMany .
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function likes()
    {
    	return $this->belongsToMany('App\Content', 'likes', 'user_id', 'content_id');
    }
  
    /**
     * User belongsToMany .
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function friends()
    {
    	return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }
  
    public function followers()
    {
    	return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }
  
    public function getImageAttribute($value)
    {
      return asset($value);
    }
}
