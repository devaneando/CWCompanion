<?php

declare (strict_types = 1);

namespace App\Controller\CRUD\Shared;

use App\Traits\LoggedUserTrait;
use App\Traits\Services\LoggerTrait;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @Security ("has_role('ROLE_WRITER')") */
abstract class AbstractSharedController extends CRUDController
{
    use LoggedUserTrait;
    const TYPE_HTML = 'html';
    const TYPE_MARKDOWN = 'markdown';

    const ACTION_DELETE = 'delete';
    const ACTION_EDIT = 'edit';
    const ACTION_VIEW = 'view';

    use LoggerTrait;


    public function cancelAction(Request $request): Response
    {
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /** @inheritDoc */
    public function createAction(): Response
    {
        return parent::createAction();
    }

    /** @inheritDoc */
    public function deleteAction($id)
    {
        $object = $this->admin->getObject($id);
        $this->denyAccessUnlessGranted(self::ACTION_DELETE, $object);

        return parent::deleteAction($id);
    }

    /** @inheritDoc */
    public function editAction($id = null)
    {
        $object = $this->admin->getObject($id);
        $this->denyAccessUnlessGranted(self::ACTION_EDIT, $object);

        return parent::editAction($id);
    }

    /** @inheritDoc */
    public function showAction($id = null)
    {
        $object = $this->admin->getObject($id);
        $this->denyAccessUnlessGranted(self::ACTION_EDIT, $object);
    }
}
