<?php

namespace App\Traits\Repository;

use App\Entity\Repository\SceneRepository;

trait SceneRepositoryTrait
{
    /** @var SceneRepository $sceneRepository */
    private $sceneRepository;

    public function getSceneRepository(): SceneRepository
    {
        return $this->sceneRepository;
    }

    public function setSceneRepository(SceneRepository $sceneRepository): self
    {
        $this->sceneRepository = $sceneRepository;

        return $this;
    }
}
