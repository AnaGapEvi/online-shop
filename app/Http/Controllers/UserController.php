<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = $request->validate([
                'first_name'=>'required',
                'last_name'=>'required',
                'email'=>'required|email',
                'birthday'=>'required|date',
                'gender'=>'required',
                'password' => 'required|min:8',
        ]);

        if(!$validator) return response()->json($validator->errore());

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
        return response()->json(['token' => $token], 200);
    }

    public function verify(Request $request): JsonResponse
    {
        $user = User::where('email', '=', $request->email)->first();

        if ($user->reg_token === $request->token) {
            $user->reg_token = null;
            $user->email_verified_at = Carbon::now();
            $user->save();
            return response()->json(['message'=>'Finished']);
        }else{
            return response()->json(['error'=>'Something went wrong'], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $validator = $request->validate([
            'email'=>'required|email',
            'password' => 'required',
        ]);
        if(!$validator) return response()->json($validator->erroe());

        $user = User::query()->where('email', $request->email,)->first();

        if(!$user) return response()->json(["message" =>'User does not exist'], 422);

        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];

            return response()->Json($response);
        } else {
            $response = ["message" => "Password mismatch"];

            return response()->json($response, 422);
        }
    }

    public function updateProfile(Request $request): JsonResponse
    {
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

    public function me(): JsonResponse
    {
        return response()->json(['user' => auth()->user()]);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $user = User::query()->where('email', $request->email,)->first();
        $user->password ='';

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json($user);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
