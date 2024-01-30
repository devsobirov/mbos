<?php

namespace App\Observers;

use App\Helpers\LogTypeHelper;
use App\Models\Project;
use App\Traits\HasLoggableUpdates;

class ProjectObserver
{
    use HasLoggableUpdates;

    protected $groupType = Project::class;
    protected $groupName = 'Project';

    public function created($project)
    {
        $this->logEvent($this->groupName. ' ID:'.$project->id. ' yaratildi', $project, LogTypeHelper::TYPE_SUCCESS);
    }

    public function updated($project)
    {
        $this->logEvent($this->groupName. ' ID:'.$project->id. ' tahrirlandi', $project, LogTypeHelper::TYPE_WARNING, true);
    }

    public function deleted($project)
    {
        $this->logEvent($this->groupName. ' ID:'.$project->id. ' o\'chirildi', $project, LogTypeHelper::TYPE_DANGER);
    }

    public function restored($project)
    {
        $this->logEvent($this->groupName. ' ID:'.$project->id. ' qayta tiklandi', $project, LogTypeHelper::TYPE_DANGER);
    }
}
