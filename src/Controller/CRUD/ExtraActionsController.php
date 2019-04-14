<?php

declare (strict_types = 1);

namespace App\Controller\CRUD;

use App\Exception\Permissions\NoValidChapter;
use App\Exception\Permissions\NoValidProject;
use App\Exception\Permissions\NoValidScene;
use App\Traits\LoggedUserTrait;
use App\Traits\Services\LoggerTrait;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

abstract class ExtraActionsController extends CRUDController
{
    use LoggedUserTrait;
    const TYPE_HTML = 'html';
    const TYPE_MARKDOWN = 'markdown';

    const ACTION_DELETE = 'delete';
    const ACTION_EDIT = 'edit';
    const ACTION_PREVIEW = 'preview';
    const ACTION_VIEW = 'view';

    /** The folder used to keep preview templates */
    protected $templateFolder = null;

    /** If true, will allow a preview action */
    protected $allowPreview = false;

    /** If true, the user won't be able to create objects without an existent Project */
    protected $requireProject = false;

    /** If true, the user won't be able to create objects without an existent Chapter */
    protected $requireChapter = false;

    /** If true, the user won't be able to create objects without an existent Scene */
    protected $requireScene = false;

    use LoggerTrait;

    public function cancelAction(Request $request): Response
    {
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /** @throws NotFoundHttpException If allowPreview is false */
    protected function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        if (false === $this->allowPreview) {
            throw new NotFoundHttpException('This is not the page you are looking for.', null, 1);
        }
        $this->denyAccessUnlessGranted(self::ACTION_PREVIEW, $object);

        if (self::TYPE_MARKDOWN === strtolower($type)) {
            return new Response(
                $this->renderView('Admin/preview/' . $this->templateFolder . '/view.md.twig', ['object' => $object])
            );
        } elseif (self::TYPE_HTML === strtolower($type)) {
            return new Response(
                $this->renderView('Admin/preview/' . $this->templateFolder . '/view.html.twig', ['object' => $object])
            );
        }

        throw new NotFoundHttpException('This is not the page you are looking for.', null, 1);
    }

    /**
     * @throws AccessDeniedException If access is not granted
     * @throws \RuntimeException If no editable field is defined
     * @throws NoValidProject If the user has no project and it is required
     * @throws NoValidChapter If the user has no chapter and it is required
     * @throws NoValidScene If the user has no scene and it is required
     */
    public function createAction(): Response
    {
        if (true === $this->requireProject && 0 >= $this->getLoggedUser()->getProjects()->count()) {
            throw new NoValidProject("Can't create this object without a project.");
        }

        if (true === $this->requireChapter && 0 >= $this->getLoggedUser()->getChapters()->count()) {
            throw new NoValidChapter("Can't create this object without a chapter.");
        }

        if (true === $this->requireScene && 0 >= $this->getLoggedUser()->getScenes()->count()) {
            throw new NoValidScene("Can't create this object without a chapter.");
        }

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
