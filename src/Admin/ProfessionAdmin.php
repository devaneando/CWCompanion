<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use App\Admin\Type\MarkDownType;

final class ProfessionAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'shared_profession';
    protected $baseRoutePattern = 'shared/profession';
    protected $datagridValues = [
        '_sort_by' => 'name',
        '_sort_order' => 'ASC',
        '_per_page' => 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];
    protected $translationDomain = 'profession';

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                    'template' => 'form/list/markdown.html.twig',
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
            ->add('description', MarkDownType::class, ['label' => 'admin.label.description']);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                    'template' => 'form/show/markdown.html.twig',
                ]
            );
    }
}
