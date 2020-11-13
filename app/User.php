<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Scopes\TenantScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use \Eloquence\Behaviours\CamelCasing;
    use Notifiable;
    use SoftDeletes;
    
    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
    
    protected $guarded = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'forget_token', 'forget_token_expires_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function tenant() {
        return $this->belongsTo('App\Models\Tenant', 'tenant_id', 'id');
    }

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new TenantScope);
    }

    public function save(array $options = []) {
        if(!empty(request()->header('tenant_id'))) {
            $this->attributes['tenant_id'] = intval(request()->header('tenant_id'));
        }
        parent::save($options);
    }    
}
