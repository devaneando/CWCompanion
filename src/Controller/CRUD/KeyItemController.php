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
    protected $allowPreview = true;
}
