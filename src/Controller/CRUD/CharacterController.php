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
    protected $allowPreview = true;
}
