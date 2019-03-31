<?php

namespace App\Traits\Repository;

use App\Entity\Repository\ProjectRepository;

trait ProjectRepositoryTrait
{
    /** @var ProjectRepository $projectRepository */
    private $projectRepository;

    public function getProjectRepository(): ProjectRepository
    {
        return $this->projectRepository;
    }

    public function setProjectRepository(ProjectRepository $projectRepository): self
    {
        $this->projectRepository = $projectRepository;

        return $this;
    }
}
