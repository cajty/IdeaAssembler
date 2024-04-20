<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Group;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class ComponetController extends Controller
{
    public function createComponent(Group $group, Request $request)
    {
        try {
            $validatedData = $request->validate([
                'content' => 'required',
            ]);
            if( $group == null){
                $indexGroup = Group :: where('topic_name' ,'All_Groups')->where('creator_id', 1)->first();
            }
            $component = Component::firstOrCreate($validatedData);
            if (!$group->Component()->where('component_id', $component->id)->exists()) {
                $group->Component()->attach($component->id);
                return response()->json(['component' => $component], 201);
            }
            return response()->json(['error' => 'Component already exists'], 500);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function updateComponent(Request $request, Group $group, Component $component)
    {
        $validatedData = $request->validate([
            'content' => 'required',
        ]);
        $componentup = Component::firstOrCreate($validatedData);


        if (!$group->Component()->where('component_id', $componentup->id)->exists()) {
            $group->Component()->attach($componentup->id);
            $group->Component()->detach($component->id);
        }


        return response()->json(['message' => 'Component updated successfully'], 201);
    }
}
