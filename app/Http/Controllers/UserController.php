<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCard;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
//use Illuminate\Foundation\Auth\ResetsPasswords;


class UserController extends Controller
{

    public function emailVerification(User $user, $token)
    {
        Mail::send('mail.verify', ['user' => $user, 'token' => $token], function ($m) use ($user){
            $m->to($user->email, $user->name)->subject('Please verify your account');
        });
    }
    public function register(Request $request)
    {
        $validator = $request->validate([

                'first_name'=>'required',
                'last_name'=>'required',
                'email'=>'required|email',
                'birthday'=>'required|date',
                'gender'=>'required',
                'password' => 'required|min:8',
        ]);

        if($validator){
            $user = User::create([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'birthday'=>$request->birthday,
                'gender'=>$request->gender,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('Laravel')->accessToken;
            $user->reg_token = $token;
            $user->save();
//            $this->emailVerification($user, $token);
            return response()->json(['token' => $token], 200);
        } else{
            return response()->json($validator->errore());
        }
    }

    public function verify(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if($user->reg_token === $request->token){
            $user->reg_token = null;
            $user->email_verified_at = Carbon::now();
            $user->save();
            return response()->json(['message'=>'Finished']);
        }else{
            return response()->json(['error'=>'Something went wrong'], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = $request->validate([
            'email'=>'required|email',
            'password' => 'required',
        ]);
        if($validator){
            $user = User::query()->where('email', $request->email,)->first();

            if($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return response($response);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 422);
                }
            } else {
                $response = ["message" =>'User does not exist'];
                return response($response, 422);
            }
        } else{
            return response()->json($validator->erroe());
        }

    }
    public function updateProfile(Request $request){

        $user = Auth::user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->birthday =$request->input('birthday');
        $user->gender=$request->input('gender');
        $user->password = Hash::make($request->password);
        if($user->email !== $request->input('email'))
        {
            $user->email = $request->input('email');
        }
        $user->save();
        return response()->json($user);
    }

    public function me()
    {
        return response()->json(['user' => auth()->user()]);
    }

    public function forgotPassword(Request $request){
        $user = User::query()->where('email', $request->email,)->first();
        $user->password ='';
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
