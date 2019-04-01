<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Exception\Permissions\NoValidProject;
use App\Traits\LoggedUserTrait;
use App\Traits\Repository\ProjectRepositoryTrait;
use App\Traits\Services\LoggerTrait;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class ExtraActionsController extends CRUDController
{
    use LoggedUserTrait;
    use ProjectRepositoryTrait;
    const TYPE_HTML = 'html';
    const TYPE_MARKDOWN = 'markdown';
    protected $templateFolder = null;

    use LoggerTrait;

    public function cancelAction(Request $request): Response
    {
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    protected function preview(Request $request, $object, string $type = self::TYPE_HTML): Response
    {
        switch (strtolower($type)) {
            case self::TYPE_MARKDOWN:
                return new Response(
                    $this->renderView('Admin/preview/'.$this->templateFolder.'/view.md.twig', ['object' => $object])
                );

                break;

            case self::TYPE_HTML:
                return new Response(
                    $this->renderView('Admin/preview/'.$this->templateFolder.'/view.html.twig', ['object' => $object])
                );

            break;

            default:
                throw new NotFoundHttpException('This is not the page you are looking for.', null, 1);

                break;
        }
    }

    protected function create(): Response
    {
        if (false === $this->getProjectRepository()->userHasProjects($this->getLoggedUser())) {
            throw new NoValidProject("Can't create this object without a project.");
        }

        return parent::createAction();
    }
}
