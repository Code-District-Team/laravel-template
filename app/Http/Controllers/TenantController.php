<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\Tenant;

use Illuminate\Http\Request;
use App\Utilities\Helpers;

class TenantController extends Controller {
    
    public function get(Request $request) {
        $url = $request->root();
        $urlHostArray = explode('.', parse_url($url, PHP_URL_HOST));
        if (count($urlHostArray) > 1) {
            $domainPrefix = $urlHostArray[0];
            return Tenant::where('domain_prefix',$domainPrefix)->first();
        }
        return response()->json([
            "error" => "Tenant not found"
        ], 422);
    }
    
}