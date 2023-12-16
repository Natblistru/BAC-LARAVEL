<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;
use Mail;
use Str;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::create([
                'name' => "{$request->first_name} {$request->last_name}",
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()->json([
                'status'=>201,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>'Registered Successfully',
            ]);
        }
    }

    public function login(Request $request) {
        $validator =  Validator::make($request->all(), [
            'email' => 'required|max:191',
            'password' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::where('email', $request->email)->first();
 
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid Credentials',
                ]);
            }
            else
            {
                if($user->role_as == 1) //1=Admin
                {
                    $role = 'admin';
                    $token = $user->createToken($user->email.'_AdminToken', ['server:admin'])->plainTextToken;
                }
                else
                {
                    $role = '';
                    $token = $user->createToken($user->email.'_Token', [''])->plainTextToken;
                }

                return response()->json([
                    'status'=>200,
                    'username'=>$user->name,
                    'token'=>$token,
                    'message'=>'Login Successfully',
                    'role'=>$role,
                ]);
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Logged Out Successfully',
        ]);
    }

    public function forgot(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::where('email', $request->input('email'))->first();

            if(!$user || !$user->email) {
                return response()->json([
                    'status'=>404,
                    'message'=>'Incorect Email Address Provided',
                ]);
            }

            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return response()->json([
                'status'=>200,
                'message'=>'A code has been sent to your email address.',
            ]);
        }
    }

    public function reset($token, Request $request): JsonResponse
    {
        $validator =  Validator::make($request->all(), [
            'password' => 'required|min:8',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
        
            $user = User::where('remember_token',$token)->first();

            if(!$user ) {
                return response()->json(['message' => 'The token is not valid'], 404);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            $user->tokens()->delete();

            return response()->json([
                'status'=>200,
                // 'username'=>$user->name,
                // 'token'=>$token,
                'message'=>'Password reset successfully',
                // 'role'=>$role,
            ]);
        }

    }
}
