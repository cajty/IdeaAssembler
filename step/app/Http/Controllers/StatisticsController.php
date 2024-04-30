<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Group;
use App\Models\Topic;
use App\Models\User;



class StatisticsController extends Controller
{

    public function statistics()
    {
      
        $users = User::where('role_id', 2)->count();
        $bannedUsers = User::where('role_id', 3)->count();
        $topic = Topic::count();
        $group = Group::count();
        $component = Component::count();
        return response()->json([
            'users' => $users,
            'bannedUsers' => $bannedUsers,
            'topic' => $topic,
            'group' => $group,
            'component' => $component
        ]);
    }
}
