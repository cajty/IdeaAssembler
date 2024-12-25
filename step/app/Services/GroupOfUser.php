<?php

namespace App\Services;

use App\Models\Topic;

class GroupOfUser
{
    private static $instances = [];

    private $creatorId;
    private $groups;

    private function __construct($creatorId)
    {
        $this->creatorId = $creatorId;
    }
    public function  attachGroupIfNotExistsToTopic(int $groupId)
    {
        $topic = Topic::where('creator_id', $this->creatorId)
            ->where('topic_name', 'All_Groups')
            ->first();

        if ($topic) {
            $this->attachGroupIfNotExists($topic, $groupId);
        }
    }

    private function attachGroupIfNotExists(Topic $topic, int $groupId)
    {
        if (!$topic->Group()->where('group_id', $groupId)->exists()) {
            $topic->Group()->attach($groupId);
        }
    }
    public static function getInstance($creatorId)
    {
        if (!isset(self::$instances[$creatorId])) {
            self::$instances[$creatorId] = new self($creatorId);
        }

        return self::$instances[$creatorId];
    }

    public function loadGroups()
    {
        $this->groups = Topic::where('creator_id', $this->creatorId)
            ->where('topic_name', 'All_Groups')
            ->with('Group')
            ->get()
            ->pluck('Group')
            ->collapse();
    }

    public function getGroups()
    {
        if (!$this->groups) {
            $this->loadGroups();
        }
        return $this->groups;
    }
}
