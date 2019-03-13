<?php

namespace App\Controller;

use App\Entity\Character;
use App\Traits\Services\LoggerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/writer")
 */
class ExportCharacterController extends AbstractController
{
    const TYPE_HTML = 'html';
    const TYPE_MARKDOWN = 'markdown';
    use LoggerTrait;

    /**
     * @Route("/export/character/{slug}", name="export_character_by_slug")
     * @Route("/export/character/{slug}/{type}", name="export_character_by_slug_type")
     * @ParamConverter("character", options={"mapping": {"slug": "slug"}})
     */
    public function exportById(Character $character, string $type = self::TYPE_HTML)
    {
        switch (strtolower($type)) {
            case self::TYPE_MARKDOWN:
                return new Response(
                    $this->renderView('export/character/view.md.twig', ['character' => $character])
                );

                break;

            case self::TYPE_HTML:
                return new Response(
                    $this->renderView('export/character/view.html.twig', ['character' => $character])
                );

            break;

            default:
                throw new NotFoundHttpException('This is not the page you are looking for.', null, 1);

                break;
        }
    }
}
