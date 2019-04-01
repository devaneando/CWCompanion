<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Chapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ChapterController extends ExtraActionsController
{
    protected $templateFolder = 'chapter';
    protected $allowPreview = true;
}
