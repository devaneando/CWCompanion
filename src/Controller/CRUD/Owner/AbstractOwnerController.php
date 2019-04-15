<?php

declare (strict_types = 1);

namespace App\Controller\CRUD\Owner;

use App\Exception\Permissions\NoValidChapter;
use App\Exception\Permissions\NoValidProject;
use App\Exception\Permissions\NoValidScene;
use App\Traits\LoggedUserTrait;
use App\Traits\Services\LoggerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/** @Security("has_role('ROLE_WRITER')") */
abstract class AbstractOwnerController extends CRUDController
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

    /**
     * @throws AccessDeniedException If access is not granted
     * @throws \RuntimeException If no editable field is defined
     * @throws NoValidProject If the user has no project and it is required
     * @throws NoValidChapter If the user has no chapter and it is required
     * @throws NoValidScene If the user has no scene and it is required
     *
     * @return Response
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

    /** {@inheritdoc} */
    public function deleteAction($id)
    {
        $object = $this->admin->getObject($id);
        $this->denyAccessUnlessGranted(self::ACTION_DELETE, $object);

        return parent::deleteAction($id);
    }

    /** {@inheritdoc} */
    public function editAction($id = null)
    {
        $object = $this->admin->getObject($id);
        $this->denyAccessUnlessGranted(self::ACTION_EDIT, $object);

        return parent::editAction($id);
    }

    /**
     * @Security("has_role('ROLE_WRITER')")
     *
     * @param Request $request
     * @param mixed $object The object to be previewed
     * @param string $type If the preview should be displayed in markdown or html
     *
     * @return Response
     */
    protected function previewAction(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        $this->denyAccessUnlessGranted(self::ACTION_PREVIEW, $object);

        $template = 'Admin/preview/' . $this->templateFolder . '/view.';
        $template = (self::TYPE_MARKDOWN === strtolower($type)) ? 'md.twig' : 'html.twig';

        return new Response(
            $this->renderView($template, ['object' => $object])
        );
    }

    /** {@inheritdoc} */
    public function showAction($id = null)
    {
        $object = $this->admin->getObject($id);
        $this->denyAccessUnlessGranted(self::ACTION_EDIT, $object);
    }
}
