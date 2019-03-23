<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Traits\Services\LoggerTrait;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class ExtraActionsController extends CRUDController
{
    use LoggerTrait;

    public function cancelAction(Request $request)
    {
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
