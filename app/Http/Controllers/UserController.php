<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Tenant;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Scopes\TenantScope;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {
    
  
    
    public function login(Request $request) {
        $request->validate([
            'email' => ['required', Rule::exists('users', 'email')],
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        
        //finding user by email
        $user = User::withoutGlobalScope(TenantScope::class)->with('tenant')->where('email', $email)->first();
        //getting hash of password
        //$hashedPassword = md5($request->input('password'));
        
        //checking hashed password matches the user's password
        if(strcmp($password, $user->password) == 0) {
            //generating api_token
            $token = uniqid($user->id);
            //adding token to user
            $user->api_token = $token;
            //saving user
            $user->save();
            //logging in user
            Auth::login($user);
            //returning user
            return $user;
        }
        else {
            return response()->json([
                'message' => "Invalid Username or Password",
            ], 403);
        }
    }
    
    public function logout(Request $request) {
        //getting logged in user
        $user = Auth::user();
        $userModel = User::find($user->id);
        $userModel->api_token = null;
        $userModel->save();
        Auth::logout();
        return $userModel;
    }

    public function register(Request $request) {
        $id = $request->input('id');
        $user = null;
        
        // Creating validate array
        $validateArray = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required','email',Rule::unique('users', 'email')->ignore((!empty($id)) ? $id : 0)],
            'password' => 'required',
            'company_name' => 'required',
            'domain_prefix' => ['required', 'unique:tenants,domain_prefix']
        ];
        
        $request->validate($validateArray);

        try {

            DB::beginTransaction();
            $userData = $request->except(['company_name', 'domain_prefix']);
            $userData['name'] = $userData['first_name'] . ' ' . $userData['last_name'];
            $tenant = Tenant::create($request->only(['company_name', 'domain_prefix']));
            $userData['tenant_id'] = $tenant->id;
            $userData['type'] = UserType::Admin;
            $user = User::create($userData);


            DB::commit();

        } catch(Throwable $e) {
            DB::rollback();
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
        
        return $user;//User::where('id', $user->id)->first();
    }

}