<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Topic;
 use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response ;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8'],
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
            ]);
            if($user){
                Topic::create([
                    'topic_name' => 'All_Groups',
                    'description' => 'All groups of user',
                    'category_id' => 1,
                    'creator_id' => $user->id,
                    'is_public' => 1,
                    'like_count' => 0,
                    'dislike_count' => 0,
                ]);
            }
            DB::commit();
            return response()->json([
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }

  

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string', 'min:8'],
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'message' => 'User Logged In Successfully',
                'user' => $user->only('name','role_id'),
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (QueryException $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
  
    public function user(){
        $user =Auth::user();

        if($user){
            return response()->json([
                'user' =>$user,
            ],Response::HTTP_OK);
        }else{
            return Response()->json([
                'message'=>'not login',
            ],Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request)
{
    try {
        $user = $request->user();
        // Revoke all user tokens
        $user->tokens()->delete();

        return response()->json([
            'message' => 'User Logged Out Successfully'
        ], 200);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}
}

