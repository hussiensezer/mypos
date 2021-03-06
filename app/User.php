<?php

namespace App;

use App\Models\Order;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
class User extends Authenticatable
{
    use Notifiable,LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','image',
    ];

    protected $appends = ['image_path'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFirstNameAttribute($val) {
        return ucfirst($val);
    }// end of first name

    public function getLastNameAttribute($val) {
        return ucfirst($val);
    }// end of last name

    public function getImagePathAttribute() {
        return asset('uploads/user_images/' . $this->image);
    }// end of image path


}
