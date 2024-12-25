<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use DOMDocument;

class IdeaController extends Controller
{
    public function getUserIdeas()
    {
        $ideas = Idea::where('user_id', 1)->get();
        return response()->json($ideas);
    }

    
    public function store(Request $request)
    {
       
        // $description = $request->description;

        // $dom = new DOMDocument();
        // $dom->loadHTML($description, 9);

        // $images = $dom->getElementsByTagName('img');

        // foreach ($images as $key => $img) {
        //     $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
        //     $image_name = "/upload/" . time() . $key . '.png';
        //     file_put_contents(public_path() . $image_name, $data);

        //     $img->removeAttribute('src');
        //     $img->setAttribute('src', $image_name);
        // }
        // $description = $dom->saveHTML();

        try {
            $idea = Idea::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => 1
            ]);
        
            return response()->json($idea, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ideas = Idea::find($id);
        return response()->json($ideas);
    }

   
    public function update(Request $request, Idea $idea)
    {
       
    
     

        // $description = $request->description;

        // $dom = new DOMDocument();
        // $dom->loadHTML($description, 9);

        // $images = $dom->getElementsByTagName('img');

        // foreach ($images as $key => $img) {

        //     // Check if the image is a new one
        //     if (strpos($img->getAttribute('src'), 'data:image/') === 0) {

        //         $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
        //         $image_name = "/upload/" . time() . $key . '.png';
        //         file_put_contents(public_path() . $image_name, $data);

        //         $img->removeAttribute('src');
        //         $img->setAttribute('src', $image_name);
        //     }
        // }
        // $description = $dom->saveHTML();

        $idea->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Idea updated successfully', 
        'idea' => $idea]);
    }

 
    public function destroy($id)
    {
        $idea = Idea::find($id);

        $dom = new DOMDocument();
        $dom->loadHTML($idea->description, 9);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {

            $src = $img->getAttribute('src');
            $path = Str::of($src)->after('/');


            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $idea->delete();
        return response()->json(['message' => 'Idea deleted successfully']);
    }
}
