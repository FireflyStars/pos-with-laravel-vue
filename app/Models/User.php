<?php

namespace App\Models;

use App\Models\Affiliate;
use App\Models\campagne_card;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoles(){
        $roles_ids=[];
        $roles_ids[]=$this->role_id;
        $user_roles=DB::table('user_roles')->select('role_id')->where('user_id','=',$this->id)->get();
        foreach ($user_roles as $role){
            $roles_ids[]=$this->role_id;
        }
        $roles=DB::table('roles')->select('name')->whereIn('id',$roles_ids)->get();
        return $roles;
    }

    public function affiliate(){
        return $this->belongsTo(Affiliate::class);
    }

    public function orders() 
    {
        return $this->hasMany(Order::class, 'affiliate_id');
    }

    public function card() 
    {
        return $this->hasMany(campagne_card::class);
    }

}
