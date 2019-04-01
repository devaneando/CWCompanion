<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ProjectController extends ExtraActionsController
{
    protected $templateFolder = 'project';
    protected $allowPreview = true;
}
