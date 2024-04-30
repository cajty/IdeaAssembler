<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Services\GroupOfUser;



class GroupController extends Controller
{

    public function getUserGroup()
    {
        try {

            $groupOfUser = GroupOfUser::getInstance(1);
            $groups = $groupOfUser->getGroups();
    
            return response()->json($groups);
        } catch (QueryException $e) {

            return response()->json(['error' => 'Failed to fetch user groups'], 500);
        }
    }


    public function create(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'name' => 'required | string | max:255',
                'components' => 'required|array',
                'components.*.content' => 'required',
            ]);

            $group = Group::create([
                'name' => $validatedData['name'],
            ]);
            $components = [];

            foreach ($validatedData['components'] as $componentData) {
                $component = Component::firstOrCreate(['content' => $componentData['content']]);


                if (!$group->Component()->where('component_id', $component->id)->exists()) {
                    $group->Component()->attach($component->id);
                    $components[] = $component;
                }
            }
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        $group->load('component');

        return response()->json([
            $group,
        ], 201);
    }


    public function show(Group $group)
    {
        $components = $group->Component;
        return response()->json([
            'group' => $group->name,
            'components' => $components
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $group->update($validatedData);
        return response()->json(
            ['group' => $group->name]
        );
    }


    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json(['message' => 'Group deleted successfully']);
    }
    public function destroyComponent(Group $group, Component $component)
    {
        $group->Component()->detach($component->id);
        return response()->json(['message' => 'Component removed from the group']);
    }
}
