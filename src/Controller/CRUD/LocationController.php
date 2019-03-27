<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Location;
use Symfony\Component\HttpFoundation\Request;

final class LocationController extends ExtraActionsController
{
    protected $templateFolder = 'location';

    /**
     * @Route("/{id}/preview/{type}", name="writing_location_preview")
     */
    public function previewAction(Request $request, Location $object, string $type = self::TYPE_HTML)
    {
        return $this->preview($request, $object, $type);
    }
}
