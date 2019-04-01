<?php

namespace App\Traits\Repository;

use App\Entity\Repository\ChapterRepository;

trait ChapterRepositoryTrait
{
    /** @var ChapterRepository $chapterRepository */
    private $chapterRepository;

    public function getChapterRepository(): ChapterRepository
    {
        return $this->chapterRepository;
    }

    public function setChapterRepository(ChapterRepository $chapterRepository): self
    {
        $this->chapterRepository = $chapterRepository;

        return $this;
    }
}
