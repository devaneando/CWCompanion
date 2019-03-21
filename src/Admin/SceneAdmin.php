<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class SceneAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'project_scene';
    protected $baseRoutePattern = 'project/scene';
    protected $datagridValues = [
        '_sort_by'=> 'name',
        '_sort_order'=> 'ASC',
        '_per_page'=> 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];
    protected $translationDomain = 'scene';

    public function preUpdate($object)
    {
        /** @var Project $object */
        if (null === $object->getUploadedPicture() && null === $object->getPicture()) {
            $object->setDefaultPicture();
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('scene')
            ->add('ambient')
            ->add('time')
            ->add('description')
            ->add('notes')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('scene')
            ->add('ambient')
            ->add('time')
            ->add('description')
            ->add('notes')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('id')
            ->add('scene')
            ->add('ambient')
            ->add('time')
            ->add('description')
            ->add('notes')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('scene')
            ->add('ambient')
            ->add('time')
            ->add('description')
            ->add('notes')
            ;
    }
}
