<?php

namespace App\Repository;

use App\Models\Tag;

class TagRepository implements ITagRepository
{
    public function getAll()
    {
        return Tag::all();
    }

    public function create(array $data)
    {
        return Tag::firstOrCreate($data);
    }

    public function delete($id)
    {
        $Tag = Tag::find($id);
        if ($Tag) {
            $Tag->delete();
        }
    }

    public function update($id, $data)
    {
        $Tag = Tag::find($id);
        if ($Tag) {
            $Tag->update($data);
        }
    }
}