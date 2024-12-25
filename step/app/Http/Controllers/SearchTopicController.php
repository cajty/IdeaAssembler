<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Carbon\Carbon;

 

class SearchTopicController extends Controller
{
    public function search(Request $request)
    {

        


        $query = Topic::query();
        $query->where('is_public', 1);
        $userId = 1;

        if ($request->has('topic_name')) {
            $searchTerm = $request->input('topic_name');
            $query->where('topic_name', 'LIKE', "%{$searchTerm}%");
        }

        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            $query->where('category_id', $categoryId);
        }

        if ($request->has('filter') && $request->has('time')) {
            return response()->json($request->input('filter'));
            switch ($request->input('time')) {
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
            $query->orderBy('like_count', 'desc');
        }


        $topics = $query->with(['Feedback' => function ($query) use ($userId) {
            $query->select("topic_id",'is_like')->where('user_id', $userId);
        }])->get()->map(function ($topic) {
            if (count($topic->Feedback) > 0) {
                $topic->is_like = $topic->Feedback[0]->is_like;
            } else {
                $topic->is_like = null;
            }
            unset($topic->Feedback);
            return $topic;
        });

        // $topics = $query->with(['Feedback' => function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // }])->get();

        return response()->json($topics);
    }
}
