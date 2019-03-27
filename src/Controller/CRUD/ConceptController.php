<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Concept;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ConceptController extends ExtraActionsController
{
    protected $templateFolder = 'concept';

    /**
     * @Route("/{id}/preview/{type}", name="writing_concept_preview")
     */
    public function previewAction(Request $request, Concept $object, string $type = self::TYPE_HTML)
    {
        return $this->preview($request, $object, $type);
    }
}
