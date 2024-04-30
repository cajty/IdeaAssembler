<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    //
    public function getUsers(){
        $user = User::where("role_id","!=", 1)->get();
        return response()->json($user);
    }

    public function banndUser(User $user)
    {
        $user->update(["role_id" => 3]);
        return response()->json($user);
    }

    public function inbanndUser(User $user){
        $user->update(["role_id" => 2]);
        return response()->json($user);
    }
}
