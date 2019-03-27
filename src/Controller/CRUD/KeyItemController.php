<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\KeyItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class KeyItemController extends ExtraActionsController
{
    protected $templateFolder = 'key-item';

    /**
     * @Route("/{id}/preview/{type}", name="writing_key_item_preview")
     */
    public function previewAction(Request $request, KeyItem $object, string $type = self::TYPE_HTML)
    {
        return $this->preview($request, $object, $type);
    }
}
