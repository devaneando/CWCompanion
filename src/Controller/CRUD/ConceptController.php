<?php

declare (strict_types = 1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ConceptController extends ExtraActionsController
{
    protected $templateFolder = 'concept';
    protected $allowPreview = true;
    protected $enforceOwner = true;

    /**
     * @Route("/concept/{id}/preview/{type}", name="writing_concept_preview")
     * @ParamConverter("object", class="App\Entity\Concept", options={"mapping": {"id" = "id"}})
     *
     * @param mixed $object
     */
    public function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        return parent::previewAction($request, $object, $type);
    }
}
