<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use \App;

class TenantScope implements Scope {

    public function apply(Builder $builder, Model $model)
    {
        if(!App::runningInConsole()) {
            $builder->where($model->table . '.tenant_id', request()->header('tenant_id'));
        }
    }

}