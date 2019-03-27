<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Concept;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ConceptController extends ExtraActionsController
{
    /**
     * @Route("/{id}/preview/{type}", name="writing_concept_preview")
     */
    public function previewAction(Request $request, Concept $concept, string $type = self::TYPE_HTML)
    {
        switch (strtolower($type)) {
            case self::TYPE_MARKDOWN:
                return new Response(
                    $this->renderView('Admin/preview/concept/view.md.twig', ['concept' => $concept])
                );

                break;

            case self::TYPE_HTML:
                return new Response(
                    $this->renderView('Admin/preview/concept/view.html.twig', ['concept' => $concept])
                );

            break;

            default:
                throw new NotFoundHttpException('This is not the page you are looking for.', null, 1);

                break;
        }
    }
}
