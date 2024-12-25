<?php

namespace App\Http\Controllers;

use App\Services\ITagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TagController extends Controller
{
    protected $TagService;

    public function __construct(ITagService $TagService)
    {
        $this->TagService = $TagService;
    }

    public function allTag()
    {
        $Tags = $this->TagService->getAllTags();
        return response()->json($Tags);
    }


    public function storeTag(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tags = $this->TagService->createTag(['name' =>  $request->name]);


        return response()->json($tags);
    }


    public function deleteTag($id)
    {
        $this->TagService->deleteTag($id);
        return response()->json(['message' => 'Tag deleted successfully']);
    }

    public function editTag(Request $request, $id)
    {
        $tag = $this->TagService->updateTag($id, ['name' => $request->name]);
        return response()->json(['message' => 'Tag updated successfully']);
    }
}
