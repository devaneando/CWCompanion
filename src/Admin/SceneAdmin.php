<?php

declare (strict_types = 1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Type\AmbientType;
use App\Admin\Type\ChapterType;
use App\Admin\Type\MarkDownType;
use App\Admin\Type\SceneType;
use App\Admin\Type\TimeType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class SceneAdmin extends AbstractExtraActionsAdmin
{
    protected $baseRouteName = 'project_scene';
    protected $baseRoutePattern = 'project/scene';
    protected $translationDomain = 'scene';
    protected $hasRoutePreview = true;

    public function createQuery($context = 'list')
    {
        return $this->ownerOnlyListQuery($context);
    }

    public function preUpdate($object)
    {
        if (null === $object->getOwner()) {
            $object->setOwner($this->getLoggedUser());
        }
    }

    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('scene', null, ['label' => 'admin.label.scene'])
            ->add('ambient', null, ['label' => 'admin.label.ambient'])
            ->add('time', null, ['label' => 'admin.label.time'])
            ->add('location', null, ['label' => 'admin.label.time']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add(
                'chapter',
                null,
                [
                    'label' => 'admin.label.chapter',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add(
                'scene',
                null,
                [
                    'label' => 'admin.label.scene',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add(
                'ambient',
                null,
                [
                    'label' => 'admin.label.ambient',
                    'template' => 'form/list/ambient.html.twig',
                ]
            )
            ->add(
                'time',
                null,
                [
                    'label' => 'admin.label.time',
                    'template' => 'form/list/time.html.twig',
                ]
            )
            ->add(
                'location',
                null,
                [
                    'label' => 'admin.label.location',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'list' => ['template' => 'CRUD/list__action_preview.html.twig'],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('bl_001', ['class' => 'col-md-6', 'label' => 'admin.block.bl_001'])
            ->add('chapter', ChapterType::class, ['label' => 'admin.label.chapter'])
            ->add('scene', SceneType::class, ['label' => 'admin.label.scene'])
            ->add('ambient', AmbientType::class, ['label' => 'admin.label.ambient'])
            ->add('time', TimeType::class, ['label' => 'admin.label.time'])
            ->add('location', null, ['label' => 'admin.label.location'])
            ->end()
            ->with('bl_002', ['class' => 'col-md-6', 'label' => 'admin.block.bl_002'])
            ->add('characters', null, ['label' => 'admin.label.characters'])
            ->add('keyItems', null, ['label' => 'admin.label.key_items'])
            ->end()
            ->with('bl_003', ['class' => 'col-md-12', 'label' => 'admin.block.bl_002'])
            ->add('description', MarkDownType::class, ['label' => 'admin.label.description'])
            ->add('notes', MarkDownType::class, ['label' => 'admin.label.notes'])
            ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with('bl_001', ['class' => 'col-md-6', 'label' => 'admin.block.bl_001'])
            ->add('chapter', null, ['label' => 'admin.label.chapter'])
            ->add('scene', null, ['label' => 'admin.label.scene'])
            ->add(
                'ambient',
                null,
                [
                    'label' => 'admin.label.ambient',
                    'template' => 'form/show/ambient.html.twig',
                ]
            )
            ->add(
                'time',
                null,
                [
                    'label' => 'admin.label.time',
                    'template' => 'form/show/time.html.twig',
                ]
            )
            ->add(
                'location',
                null,
                [
                    'label' => 'admin.label.location',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->end()
            ->with('bl_002', ['class' => 'col-md-6', 'label' => 'admin.block.bl_002'])
            ->add(
                'characters',
                null,
                [
                    'label' => 'admin.label.characters',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->add(
                'keyItems',
                null,
                [
                    'label' => 'admin.label.key_items',
                    'sortable' => true,
                    'route' => ['name' => 'show'],
                ]
            )
            ->end()
            ->with('bl_003', ['class' => 'col-md-12', 'label' => 'admin.block.bl_002'])
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'notes',
                null,
                [
                    'label' => 'admin.label.notes',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end();
    }
}
