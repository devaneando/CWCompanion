<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Type\MarkDownType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;

final class ZodiacAdmin extends AbstractExtraActionsAdmin
{
    protected $baseRouteName = 'shared_zodiac';
    protected $baseRoutePattern = 'shared/zodiac';
    protected $translationDomain = 'zodiac';

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('start', null, ['label' => 'admin.label.start'])
            ->add('end', null, ['label' => 'admin.label.end']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('start', null, ['label' => 'admin.label.start'])
            ->add('end', null, ['label' => 'admin.label.end'])
            ->add('startComplementary', null, ['label' => 'admin.label.start_complementary'])
            ->add('endComplementary', null, ['label' => 'admin.label.end_complementary'])
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
            ->add('start', DatePickerType::class, ['label' => 'admin.label.start'])
            ->add('end', DatePickerType::class, ['label' => 'admin.label.end'])
            ->add('startComplementary', DatePickerType::class, ['label' => 'admin.label.start_complementary'])
            ->add('endComplementary', DatePickerType::class, ['label' => 'admin.label.end_complementary'])
            ->add('description', MarkDownType::class, ['label' => 'admin.label.description']);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('start', null, ['label' => 'admin.label.start'])
            ->add('end', null, ['label' => 'admin.label.end'])
            ->add('startComplementary', null, ['label' => 'admin.label.start_complementary'])
            ->add('endComplementary', null, ['label' => 'admin.label.end_complementary'])
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
