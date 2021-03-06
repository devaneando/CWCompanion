<?php

declare(strict_types=1);

namespace App\Admin;

use App\Traits\LoggedUserTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollection;

abstract class AbstractExtraActionsAdmin extends AbstractAdmin
{
    use LoggedUserTrait;
    protected $hasRouteCancel = true;
    protected $hasRoutePreview = false;

    protected $datagridValues = [
        '_sort_by'=> 'name',
        '_sort_order'=> 'ASC',
        '_per_page'=> 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        if (true === $this->hasRouteCancel) {
            $collection->add('cancel');
        }

        if (true === $this->hasRoutePreview) {
            $collection->add('preview', $this->getRouterIdParameter().'/preview/{type}', ['type' => 'html']);
        }
    }

    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);

        if ($this->hasRouteCancel && in_array($action, ['create', 'show', 'edit']) && $object) {
            $list['cancel'] = [
                'template' => 'Button/cancel_button.html.twig',
            ];
        }

        if ($this->hasRoutePreview && in_array($action, ['show', 'list']) && $object) {
            $list['preview'] = [
                'template' => 'Button/preview_button.html.twig',
            ];
        }

        return $list;
    }

    /**
     * Filter the list query, showing only the objects that belong to the logged user.
     *
     * @param mixed $context
     */
    public function ownerOnlyListQuery($context = 'list'): ProxyQueryInterface
    {
        /** @var ProxyQueryInterface $query */
        $query = parent::createQuery($context);
        if (false === $this->getLoggedUser()->isSuperAdmin()) {
            $rootAlias = $query->getRootAliases()[0];
            $query->andWhere($query->expr()->eq($rootAlias.'.owner', ':owner'));
            $query->setParameter(':owner', $this->getLoggedUser());
        }

        return $query;
    }
}
