<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Type\MarkDownType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ChapterAdmin extends AbstractExtraActionsAdmin
{
    protected $baseRouteName = 'project_chapter';
    protected $baseRoutePattern = 'project/chapter';
    protected $translationDomain = 'chapter';
    protected $hasRoutePreview = true;

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('project', null, ['label' => 'admin.label.project']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add(
                'project',
                null,
                [
                    'label'=> 'admin.label.project',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
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
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add(
                'project',
                null,
                [
                    'label'=> 'admin.label.project',
                    'sortable' => true,
                ]
            )
            ->add(
                'scenes',
                null,
                [
                    'label'=> 'admin.label.scenes',
                    'sortable' => true,
                ]
            )
            ->add('content', MarkDownType::class, ['label' => 'admin.label.content']);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add(
                'project',
                null,
                [
                    'label'=> 'admin.label.project',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add(
                'scenes',
                null,
                [
                    'label'=> 'admin.label.scenes',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add(
                'content',
                null,
                [
                    'label' => 'admin.label.content',
                    'template' => 'form/show/markdown.html.twig',
                ]
            );
    }
}
