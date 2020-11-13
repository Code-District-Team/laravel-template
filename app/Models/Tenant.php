<?php
/**
 * Created by PhpStorm.
 * User: aliehsan
 * Date: 2020-01-16
 * Time: 14:46
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tenant extends Model {

    use SoftDeletes;

    public $table = 'tenants';

    protected $fillable = ['company_name', 'domain_prefix'];

        /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];


    use \Eloquence\Behaviours\CamelCasing;
    
    public function users() {
        return $this->hasMany('App\User', 'tenant_id', 'id');
    }

}