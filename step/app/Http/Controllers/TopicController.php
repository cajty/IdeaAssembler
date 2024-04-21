<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class TopicController extends Controller
{
    public function getUserTopic()
    {
        $topics = Topic::where('creator_id', 1)->get();
        return response()->json($topics);
    }

    public function getUserGroup()
    {
        $groups = Topic::where('topic_name', 'All_Groups')->where('creator_id', 1)->get();

        return response()->json($groups);
    }





    public function attachGroupsToTopic($topic, $groupIds)
    {
        foreach ($groupIds as $groupId) {
            if (!$topic->Group()->where('group_id', $groupId)->exists()) {
                $topic->Group()->attach($groupId);
            }
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
                'names' => 'required|array',
                'names.*' => 'required|string|max:100',
            ]);

            $topic = Topic::create([
                'topic_name' => $validatedData['topic_name'],
                'description' => $validatedData['description'],
                'category_id' => $validatedData['category_id'],
                'creator_id' => 1,
                'like_count' => 0,
                'dislike_count' => 0,
            ]);

            $this->attachGroupsToTopic($topic, $validatedData['groups']);
            $this->attachTagsToTopic($topic, $validatedData['names']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        $topicInfo = $topic->only('id', 'topic_name', 'description');
        $topicGroups = $topic->Group->map(function ($group) {
            return [
                'id' => $group->id,
                'name' => $group->name,
            ];
        });

        return response()->json([
            'Topic_all_info' => $topicInfo,
            'topic_Groups' => $topicGroups,
        ]);
    }






    public function show(Topic $topic)
    {

        $topic->load('Group.component', 'Category');
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
        foreach($tags_id as $tag_id){
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
