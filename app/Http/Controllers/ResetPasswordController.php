<?php

namespace App\Http\Controllers;



use Auth;
use Hash;
use Carbon\Carbon;
use App\User;
use App\Scopes\TenantScope;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Utilities\Constants;

class ResetPasswordController extends Controller
{
    public function sendPasswordResetToken(Request $request)
    {
        
        $request->validate([
            'email' => ['required', Rule::exists('users', 'email')],
        ]);


        try {
            $email = $request->email;
            $user = User::withoutGlobalScope(TenantScope::class)->with('tenant')->where('email', $email)->first();
            if ( !$user ) 
            {

                return response()->json([
                    "message" => "Email is not regitered with any user"
                ], 404);
            }
            else
            {
                $token =  $this->generateToken();
                $name = $user->name;
                // $domainPrefix = $user->tenant->domainPrefix;

                User::withoutGlobalScope(TenantScope::class)
                    ->with('tenant')->where('email', $email)
                    ->update([
                        'forget_token' => $token,
                        'forget_token_expires_at' => Carbon::now()->addDays(1)
                    ]);
        
                $to_name = $name;
                $to_email = $email;
                $data = array(
                    "name"=>$name, 
                    "request" => "A Request has been recieved to change the password for your Bottom Line Saving account.",
                    "resetButton" => "http://localhost.com:3000/set-password?token=".$token,
                    "didNotInitiate" => "If you did not initiate this request, please contact us immediately at ".Constants::SupportEmail,
                    "thankYou"   => "Thank you,",
                    "companyname" => "Bottom Line Savings" 
                );
                Mail::send("emails.resetPassword", $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                    ->subject("Reset Password Notification");
                    $message->from(Constants::SenderEmail,Constants::SenderName);
                });

                return response()->json([
                    "success" => "An Email has been sent to ".$to_email." please check your email"
                ], 200);

            }

        } 
        catch(Throwable $e) 
        {
            DB::rollback();
            return response()->json([
                "message" => $e->getMessage()
            ], 422);
        }
    }

    private function generateToken()
    {
        // This is set in the .env file
        $key = config('app.key');

        // Illuminate\Support\Str;
        if (Str::startsWith($key, 'base64:')) 
        {
            $key = base64_decode(substr($key, 7));
        }
        return hash_hmac('sha256', Str::random(40), $key);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required |min:8',
        ]);

        try
        {
            $password = $request->password;
            $user = User::withoutGlobalScope(TenantScope::class)->with('tenant')->where('forget_token', $request->token)->first();
            if (!$user || $user->forget_token != $request->token )
            {
                return response()->json([
                    "message" => "Invalid token"
                ], 400);
            }
            elseif($user->forget_token_expires_at < Carbon::now() )
            {
                return response()->json([
                    "message" => "Token Expired"
                ], 400);
            }
            else
            {
                // 68a0099b3f45357798639a30c5fe3154 real password
                $user->password = $request->password;
                $user->forget_token = null;
                $user->forget_token_expires_at = null;
                $user->update(); //or $user->save();
        
                //do we log the user directly or let them login and try their password for the first time ? if yes 
                Auth::login($user);

                return $user;
            } 
        } 
        catch(Throwable $e) 
        {
            DB::rollback();
            return response()->json([
                "message" => $e->getMessage()
            ], 422);
        }

   
        
    }
}
