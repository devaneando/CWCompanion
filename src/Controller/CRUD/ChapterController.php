<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Chapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ChapterController extends ExtraActionsController
{
    protected $templateFolder = 'chapter';

    /**
     * @Route("/{id}/preview/{type}", name="writing_chapter_preview")
     */
    public function previewAction(Request $request, Chapter $object, string $type = self::TYPE_HTML)
    {
        return $this->preview($request, $object, $type);
    }

    /** {@inheritdoc} */
    public function createAction()
    {
        return $this->create();
    }
}
