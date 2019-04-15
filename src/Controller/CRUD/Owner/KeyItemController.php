<?php

declare (strict_types = 1);

namespace App\Controller\CRUD\Owner;

use App\Controller\CRUD\Owner\AbstractOwnerController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class KeyItemController extends AbstractOwnerController
{
    protected $templateFolder = 'key-item';

    /**
     * @Route("/key-item/{id}/preview/{type}", name="writing_key_item_preview")
     * @ParamConverter("object", class="App\Entity\KeyItem", options={"mapping": {"id" = "id"}})
     *
     * @param mixed $object
     */
    public function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        return parent::previewAction($request, $object, $type);
    }
}
