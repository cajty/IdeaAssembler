<?php
namespace App\Services;

use App\Repository\ITagRepository;

class TagService implements ITagService{
    protected $TagRepository;

    public function __construct(ITagRepository $TagRepository)
    {
        $this->TagRepository = $TagRepository;
    }

    public function getAllTags()
    {
        return $this->TagRepository->getAll();
    }

    public function createTag($data)
    {
        return $this->TagRepository->create($data);
    }

    public function deleteTag($id)
    {
        return $this->TagRepository->delete($id);
    }

    public function updateTag($id, $data)
    {
        return $this->TagRepository->update($id, $data);
    }
}