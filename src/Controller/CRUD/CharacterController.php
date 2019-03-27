<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Character;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class CharacterController extends ExtraActionsController
{
    public function previewAction(Request $request, Character $character, string $type = self::TYPE_HTML)
    {
        switch (strtolower($type)) {
            case self::TYPE_MARKDOWN:
                return new Response(
                    $this->renderView('Admin/preview/character/view.md.twig', ['character' => $character])
                );

                break;

            case self::TYPE_HTML:
                return new Response(
                    $this->renderView('Admin/preview/character/view.html.twig', ['character' => $character])
                );

            break;

            default:
                throw new NotFoundHttpException('This is not the page you are looking for.', null, 1);

                break;
        }
    }
}
