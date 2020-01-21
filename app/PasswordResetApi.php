<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResetApi extends Model
{
	protected $table = 'password_resets_api';

    protected $fillable = ['email', 'token'];
}
