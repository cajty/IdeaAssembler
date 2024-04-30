<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Services\GroupOfUser;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    private $groupOfUser;

    public function __construct()
    {
        $this->groupOfUser = GroupOfUser::getInstance(1);
    }
    
    public function getUserTopic(request $request)
    {
       
        $topics = Topic::where('creator_id', 1)->get();
        return response()->json($request->user()->id  );
    }

    public function getUserGroup()
    {
        $groups = Topic::where('topic_name', 'All_Groups')->where('creator_id', 1)->get();
        
        return response()->json($groups);
    }


    public function getLikeTopic()
    {

        $userId = 1;

        $topics = Topic::whereHas('Feedback', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('is_like', 1);
        })->with(['Feedback' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get()->each(function ($topic) {
            $topic->is_like = 1;
            $topic->unsetRelation('Feedback');
        });
        
        
        

        return response()->json($topics);
    }
   

public function attachGroupsToTopic(Topic $topic, array $groupIds)
{
    foreach ($groupIds as $groupId) {
        $this->attachGroupIfNotExists($topic, $groupId);
    }

    return response()->json([
        'message' => 'Groups attached successfully'
    ], 200);
}


private function attachGroupIfNotExists(Topic $topic, int $groupId)
{
    
    $this->groupOfUser->attachGroupIfNotExistsToTopic($groupId);
    if (!$topic->Group()->where('group_id', $groupId)->exists()) {
        $topic->Group()->attach($groupId);
    }
}


public function addGroup(Topic $topic, int $groupId)
{
    try {
        $this->attachGroupIfNotExists($topic, $groupId);
        
        return response()->json([
            'message' => 'Group added successfully'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to add group',
            'error' => $e->getMessage()
        ], 500);
    }
}




  

    public function attachTagsToTopic($topic, $tags)
    {
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            if (!$topic->Tag()->where('tag_id', $tag->id)->exists()) {
                $topic->Tag()->attach($tag->id);
            }
        }
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'topic_name' => 'required | string | max:255',
                'description' => 'required |max:287',
                'category_id' => 'required',
                'groups' => 'required|array',
                'tags' => 'required|array',
                'tags.*' => 'required|string|max:100',
                'isPublic' => 'required|boolean',
            ]);

            $topic = Topic::create([
                'topic_name' => $validatedData['topic_name'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'creator_id' => 1,
                'is_public' => $validatedData['isPublic'],
                'like_count' => 0,
                'dislike_count' => 0,
            ]);

            $this->attachGroupsToTopic($topic, $validatedData['groups']);
            $this->attachTagsToTopic($topic, $validatedData['tags']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }




        return response()->json([
            $topic->only('id')
        ]);
    }

public function makePublic(Topic $topic)
{
    try {
        $topic->update(['is_public' => 1]);

        return response()->json([
            'message' => 'Topic made public successfully'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to make topic public',
            'error' => $e->getMessage()
        ], 500);
    }
}







    public function show(Topic $topic)
    {

        $topic->load('Group.component', 'Category', 'Tag');
        return response()->json($topic);
    }
    public function update(Request $request, Topic $topic)
    {
        $validatedData = $request->validate([
            'name' => 'required | string | max:255',
            'description' => 'required |max:287',
        ]);
        $topic->update([
            'topic_name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
        return response()->json(
            $topic->only('id', 'topic_name', 'description')
        );
    }


    public function destroy(Topic $topic)
    {
        $topic->delete();
        return response()->json(['message' => 'Topic deleted successfully']);
    }
    public function removedGroup(Topic $topic, $group_id)
    {
        $topic->Group()->detach($group_id);
        return response()->json(['message' => 'Group removed from the Topic']);
    }

    public function removedTags(Topic $topic, $tags_id)
    {
        foreach ($tags_id as $tag_id) {
            $topic->Tag()->detach($tag_id);
        }
    }

    public function updateTag(Topic $topic, Request $request)
    {


        $validatedData = $request->validate([
            'tags_id' => 'required|array',
            'names' => 'required|array',
        ]);
        $this->removedTags($topic, $validatedData['tags_id']);
        $this->attachTagsToTopic($topic, ['names']);

        return response()->json($request->all());
    }

}





// public function addGroup(Topic $topic, array $groupIds)
// {
//     $addedGroups = [];

//     foreach ($groupIds as $groupId) {
//         if (!$topic->Group()->where('group_id', $groupId)->exists()) {
//             $topic->Group()->attach($groupId);
//             $addedGroups[] = $groupId;
//         }
//     }

//     return response()->json([
//         'message' => 'Groups added to the Topic',
//         'added_groups' => $addedGroups,
//     ]);
// }
