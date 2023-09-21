<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Response as FacadesResponse;

class AccessTokensController extends Controller
{
    public function index()
    {
        return Auth::guard('sanctum')->user()->tokens;
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
            'device_name' => ['sometimes','required'],
            'abilities' => ['array'],
        ]);

        Auth::guard('sanctum')->attempt([
            'email'
        ]);

        $user = User::whereEmail($request->email)->first();
        if($user && Hash::check($request->password,$user->password)){

            $name = $request->post('device_name' , $request->userAgent());
            $abilities = $request->post('abilities' , ['*']);
            $token = $user->createToken($name, $abilities ,now()->addDays(90));

            return Response::json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }
        return Response::json([
            'message' => __('Invalid Creadentials'),
        ], 401);
    }

    public function destyoy()
    {
        $user = Auth::guard('sanctum')->user();

        // if ($id == 'current'){
        //     // $user->currentA
        // }
    }
}
