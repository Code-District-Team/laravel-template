<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utilities;

use Str;

class Helpers {
     
    /**
     * Convert array keys to snake case recursively.
     *
     * @param  array  $array
     * @param  string $delimiter
     * @return string
     */
    public static function snakeKeys($array, $delimiter = '_') {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = Helpers::snakeKeys($value, $delimiter);
            }
            $result[Str::snake($key, $delimiter)] = $value;
        }
        return $result; 
    }
    
    public static function getCurrentTanentId() {
        return intval(request()->header('tenant_id'));
    }

}