<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

abstract class AbstractExtraActionsAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_by'=> 'name',
        '_sort_order'=> 'ASC',
        '_per_page'=> 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('cancel', $this->getBaseRouteName().'/cancel');
    }

    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);
        if (in_array($action, ['create', 'show', 'edit']) && $object) {
            $list['cancel'] = [
                'template' => 'Button/cancel_button.html.twig',
            ];
        }

        return $list;
    }
}
