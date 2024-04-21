<?php

namespace App\Services;

use App\Models\Tag;

interface ITagService
{
    public function getAllTags();
    public function createTag($data);
    public function deleteTag($id);
    public function updateTag($id, $data);
}