<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;

final class ProjectController extends ExtraActionsController
{
    protected $templateFolder = 'project';

    /**
     * @Route("/{id}/preview/{type}", name="project_project_preview")
     */
    public function previewAction(Request $request, Project $object, string $type = self::TYPE_HTML)
    {
        return $this->preview($request, $object, $type);
    }
}
