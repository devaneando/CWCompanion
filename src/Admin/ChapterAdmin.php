<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Type\MarkDownType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ChapterAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'writing_chapter';
    protected $baseRoutePattern = 'writing/chapter';
    protected $datagridValues = [
        '_sort_by'=> 'name',
        '_sort_order'=> 'ASC',
        '_per_page'=> 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];
    protected $translationDomain = 'chapter';

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
            ->add('slug', null, ['label' => 'admin.label.slug'])
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
