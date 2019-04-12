<?php

declare (strict_types = 1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProjectController extends ExtraActionsController
{
    protected $templateFolder = 'project';
    protected $allowPreview = true;
    protected $enforceOwner = true;

    /**
     * @Route("/project/{id}/preview/{type}", name="project_project_preview")
     * @ParamConverter("object", class="App\Entity\Project", options={"mapping": {"id" = "id"}})
     *
     * @param mixed $object
     */
    public function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        return parent::previewAction($request, $object, $type);
    }
}
