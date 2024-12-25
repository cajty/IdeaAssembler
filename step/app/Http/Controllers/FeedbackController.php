<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Topic;

class FeedbackController extends Controller
{
    public function getFeedback($topicId, $userId)
    {
        try {
            $feedback = Feedback::where('topic_id', $topicId)->where('user_id', $userId)->first();
            if (isset($feedback)) {
                return response()->json($feedback->is_like);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function addLike($topicId, $userId)
    {
        try {
            $feedback = Feedback::where('topic_id', $topicId)->where('user_id', $userId)->first();
    
            if (isset($feedback) && $feedback->is_like === 1) {
                return $this->removeFeedback($feedback, $topicId);
            } else if ($feedback) {
                $feedback->update(['is_like' => true]);
                $feedback->topic()->increment('like_count');
                $feedback->topic()->decrement('dislike_count');
            } else {
                $feedback = Feedback::create([
                    'topic_id' => $topicId,
                    'user_id' => $userId,
                    'is_like' => true
                ]);
                $feedback->topic()->increment('like_count');
            }
            
            $topic = Topic::find($topicId);
            
           
            $topic->is_like = $feedback->is_like;
            
            return response()->json($topic);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function addDislike($topicId, $userId)
    {
        try {
            $feedback = Feedback::where('topic_id', $topicId)->where('user_id', $userId)->first();

            if (isset($feedback) && $feedback->is_like == 0) {
                return $this->removeFeedback($feedback, $topicId);
            } else if ($feedback) {
                $feedback->update(['is_like' => false]);
                $feedback->topic()->increment('dislike_count');
                $feedback->topic()->decrement('like_count');
            } else {
                $feedback = Feedback::create([
                    'topic_id' => $topicId,
                    'user_id' => $userId,
                    'is_like' => false
                ]);
                $feedback->topic()->increment('dislike_count');
            }
            $topic = Topic::find($topicId);
            
            $topic->is_like = $feedback->is_like;
          



            return response()->json($topic);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }








    public function removeFeedback($feedback, $topicId)
    {
        try {

            if ($feedback) {
                if ($feedback->is_like === 1) {
                    $feedback->topic()->decrement('like_count');
                } else {
                    $feedback->topic()->decrement('dislike_count');
                }
            }
            $feedback->delete();
            $topic = Topic::find($topicId);
            return response()->json($topic);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
