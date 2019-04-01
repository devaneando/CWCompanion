<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\CRUD\ExtraActionsController;
use App\Entity\Concept;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ConceptController extends ExtraActionsController
{
    protected $templateFolder = 'concept';
    protected $allowPreview = true;
}
