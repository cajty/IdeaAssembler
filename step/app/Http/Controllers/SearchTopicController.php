<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Carbon\Carbon;



class SearchTopicController extends Controller
{
    public function searchByName(Request $request)
    {
        $searchTerm = $request->input('name');

        $topics = Topic::where('name', 'LIKE', "%{$searchTerm}%")->get();

        return response()->json($topics);
    }

    public function searchByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');

        $topics = Topic::where('category_id', $categoryId)->get();

        return response()->json($topics);
    }



    public function filterByLike(Request $request)
    {
        $query = Topic::query();

        switch ($$request->input('time')) {
            case 'day':
                $query->where('created_at', '>=', Carbon::now()->startOfDay());
                break;
            case 'week':
                $query->where('created_at', '>=', Carbon::now()->startOfWeek());
                break;
            case 'month':
                $query->where('created_at', '>=', Carbon::now()->startOfMonth());
                break;
            case 'year':
                $query->where('created_at', '>=', Carbon::now()->startOfYear());
                break;
            case 'all':
            default:
                break;
        }

        $topics = $query->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->get();

        return response()->json($topics);
    }
}
