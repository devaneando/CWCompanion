<?php

declare (strict_types = 1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EducationalDegreeController extends ExtraActionsController
{
    protected $templateFolder = 'educational-degree';
    protected $allowPreview = true;
    protected $requireProject = true;

    /**
     * @Route("/educational-degree/{id}/preview/{type}", name="educational_degree_preview")
     * @ParamConverter("object", class="App\Entity\EducationalDegree", options={"mapping": {"id" = "id"}})
     *
     * @param mixed $object
     */
    public function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        return parent::previewAction($request, $object, $type);
    }
}
