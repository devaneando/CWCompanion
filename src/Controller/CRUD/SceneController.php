<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Scene;
use Symfony\Component\HttpFoundation\Request;

final class SceneController extends ExtraActionsController
{
    protected $templateFolder = 'scene';

    /**
     * @Route("/{id}/preview/{type}", name="project_scene_preview")
     */
    public function previewAction(Request $request, Scene $object, string $type = self::TYPE_HTML)
    {
        return $this->preview($request, $object, $type);
    }
}
