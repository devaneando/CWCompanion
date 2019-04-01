<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Location;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class LocationController extends ExtraActionsController
{
    protected $templateFolder = 'location';
    protected $allowPreview = true;
}
