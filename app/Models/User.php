<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements JWTSubject
{
	use  HasFactory, Notifiable;
    use HasRoles;
   protected $guard_name = 'api';
//    protected $appends = ['avatar_url'];

	protected $table = 'users';

	

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nickname',
		'session',
		'hy_id',
		'name',
		'avatar',
		'phone',
		'integral',
		'coupon',
		'allmoney',
		'is_locked',
		'openid',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];
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

	public function order()
	{
		return $this->hasMany(Order::class,'user_id','id');
	}
   
	public function good()
	{
		return $this->hasMany(Good::class,'user_id','id');
	}

  

    /**
     * avatar oss url
     */
    public function getAvatarUrlAttribute()
    {
        return oss_url($this->avatar);
    }

   
}
