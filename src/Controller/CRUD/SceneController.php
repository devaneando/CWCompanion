<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Scene;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class SceneController extends ExtraActionsController
{
    protected $templateFolder = 'scene';
    protected $allowPreview = true;
    protected $requireProject = true;
    protected $requireChapter = true;
}
