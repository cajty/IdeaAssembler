<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Group;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class ComponetController extends Controller
{public function create(Group $group, Request $request)
    {
        
        try {
            $validatedData = $request->validate([
                'content' => 'required',
            ]);

            $component = Component::firstOrCreate($validatedData);
            $group->Component()->attach($component->id);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json($component, 201);
    }
}
