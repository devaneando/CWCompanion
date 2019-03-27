<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Character;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CharacterController extends ExtraActionsController
{
    protected $templateFolder = 'character';

    /**
     * @Route("/{id}/preview/{type}", name="writing_concept_preview")
     */
    public function previewAction(Request $request, Character $object, string $type = self::TYPE_HTML)
    {
        return $this->preview($request, $object, $type);
    }
}
