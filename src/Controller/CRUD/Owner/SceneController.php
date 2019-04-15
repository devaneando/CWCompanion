<?php

declare (strict_types = 1);

namespace App\Controller\CRUD\Owner;

use App\Controller\CRUD\Owner\AbstractOwnerController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SceneController extends AbstractOwnerController
{
    protected $templateFolder = 'scene';
    protected $requireProject = true;
    protected $requireChapter = true;

    /**
     * @Route("/scene/{id}/preview/{type}", name="project_scene_preview")
     * @ParamConverter("object", class="App\Entity\Scene", options={"mapping": {"id" = "id"}})
     *
     * @param mixed $object
     */
    public function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        return parent::previewAction($request, $object, $type);
    }
}
