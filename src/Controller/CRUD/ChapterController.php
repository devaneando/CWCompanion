<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ChapterController extends ExtraActionsController
{
    protected $templateFolder = 'chapter';
    protected $allowPreview = true;
    protected $requireProject = true;

    /**
     * @Route("/chapter/{id}/preview/{type}", name="project_chapter_preview")
     * @ParamConverter("object", class="App\Entity\Chapter", options={"mapping": {"id" = "id"}})
     *
     * @param mixed $object
     */
    public function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        return parent::previewAction($request, $object, $type);
    }
}
