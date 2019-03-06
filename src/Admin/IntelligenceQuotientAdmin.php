<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\EnsurePredefinedTrait;
use App\Admin\Type\MarkDownType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

final class IntelligenceQuotientAdmin extends AbstractAdmin
{
    use EnsurePredefinedTrait;
    protected $baseRouteName = 'shared_Intelligence_quotient';
    protected $baseRoutePattern = 'shared/Intelligence-quotient';
    protected $datagridValues = [
        '_sort_by' => 'name',
        '_sort_order' => 'ASC',
        '_per_page' => 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];
    protected $translationDomain = 'Intelligence_quotient';

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('minimum', null, ['label' => 'admin.label.minimum'])
            ->add('maximum', null, ['label' => 'admin.label.maximum'])
            ->add('predefined', null, ['label' => 'admin.label.predefined']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('minimum', null, ['label' => 'admin.label.minimum'])
            ->add('maximum', null, ['label' => 'admin.label.maximum'])
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
            ->add('minimum', IntegerType::class, ['label' => 'admin.label.minimum', 'attr' =>['min' => 0, 'max' => 1000, 'step' => 1]])
            ->add('maximum', IntegerType::class, ['label' => 'admin.label.maximum', 'attr' =>['min' => 0, 'max' => 1000, 'step' => 1]])
            ->add('description', MarkDownType::class, ['label' => 'admin.label.description'])
            ->add('predefined', null, ['label' => 'admin.label.predefined']);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('minimum', null, ['label' => 'admin.label.minimum'])
            ->add('maximum', null, ['label' => 'admin.label.maximum'])
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
