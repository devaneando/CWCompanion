<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Traits\EnsurePredefinedTrait;
use App\Admin\Type\MarkDownType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class GenderAdmin extends AbstractExtraActionsAdmin
{
    use EnsurePredefinedTrait;
    protected $baseRouteName = 'shared_gender';
    protected $baseRoutePattern = 'shared/gender';
    protected $translationDomain = 'gender';

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('predefined', null, ['label' => 'admin.label.predefined']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add(
                'icon',
                null,
                [
                    'label' => 'admin.label.icon',
                    'template' => 'form/list/gender.html.twig',
                ]
            )
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                    'template' => 'form/list/markdown.html.twig',
                ]
            )
            ->add('predefined', null, ['label' => 'admin.label.predefined'])
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
            ->add('code', MarkDownType::class, ['label' => 'admin.label.code'])
            ->add('icon', MarkDownType::class, ['label' => 'admin.label.icon'])
            ->add('description', MarkDownType::class, ['label' => 'admin.label.description'])
            ->add('predefined', null, ['label' => 'admin.label.predefined']);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add(
                'icon',
                null,
                [
                    'label' => 'admin.label.icon',
                    'template' => 'form/show/gender.html.twig',
                ]
            )
            ->add(
                'code',
                null,
                [
                    'label' => 'admin.label.code',
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add('predefined', null, ['label' => 'admin.label.predefined']);
    }
}
