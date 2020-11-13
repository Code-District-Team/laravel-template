<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TenantScope;
use App;

class BaseModel extends Model {
    
    use \Eloquence\Behaviours\CamelCasing;


    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new TenantScope);
    }

    public function save(array $options = []) {
        if(!App::runningInConsole()) {
            $this->attributes['tenant_id'] = intval(request()->header('tenant_id'));
        }
        parent::save($options);
    }
}