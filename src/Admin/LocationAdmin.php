<?php

declare (strict_types = 1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Type\MarkDownType;
use App\Entity\Location;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class LocationAdmin extends AbstractExtraActionsAdmin
{
    protected $baseRouteName = 'writing_location';
    protected $baseRoutePattern = 'writing/location';
    protected $translationDomain = 'location';
    protected $hasRoutePreview = true;

    public function createQuery($context = 'list')
    {
        return $this->ownerOnlyListQuery($context);
    }

    public function preUpdate($object)
    {
        /** @var Location $object */
        if (null === $object->getUploadedPicture() && null === $object->getPicture()) {
            $object->setDefaultPicture();
        }

        if (null === $object->getOwner()) {
            $object->setOwner($this->getLoggedUser());
        }
    }

    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) : void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name']);
    }

    protected function configureListFields(ListMapper $listMapper) : void
    {
        $listMapper
            ->add(
                'picture',
                null,
                [
                    'label' => 'admin.label.picture',
                    'template' => 'form/list/picture.html.twig',
                ]
            )
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('parent', null, ['label' => 'admin.label.parent', 'sortable' => true])
            ->add('children', null, ['label' => 'admin.label.children', 'sortable' => true])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'list' => ['template' => 'CRUD/list__action_preview.html.twig'],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper) : void
    {
        $pictureUploadedOptions = [
            'required' => false,
            'data_class' => null,
            'label' => 'admin.label.uploaded_picture',
        ];
        if (($subject = $this->getSubject()) && $subject->getPicture()) {
            $path = $subject->getPicture();
            $pictureUploadedOptions['help'] = '<img id="member-edit-picture" src="' . $path . '" style=" max-height: 250px;"/>';
        }
        $formMapper
            ->with('bl_001', ['class' => 'col-md-6', 'label' => 'admin.block.bl_001'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('parent', null, ['label' => 'admin.label.parent'])
            ->add('children', null, ['label' => 'admin.label.children'])
            ->end()
            ->with('bl_002', ['class' => 'col-md-6', 'label' => 'admin.block.bl_002'])
            ->add('uploadedPicture', FileType::class, $pictureUploadedOptions)
            ->end()
            ->with('bl_003', ['class' => 'col-md-12', 'label' => 'admin.block.bl_002'])
            ->add('description', MarkDownType::class, ['label' => 'admin.label.description'])
            ->add('history', MarkDownType::class, ['label' => 'admin.label.history'])
            ->add('generalNotes', MarkDownType::class, ['label' => 'admin.label.general_notes'])
            ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper) : void
    {
        $showMapper
            ->with('bl_001', ['class' => 'col-md-6', 'label' => 'admin.block.bl_001'])
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('parent', null, ['label' => 'admin.label.parent'])
            ->add('children', null, ['label' => 'admin.label.children'])
            ->end()
            ->with('bl_002', ['class' => 'col-md-6', 'label' => 'admin.block.bl_002'])
            ->add(
                'picture',
                null,
                [
                    'label' => 'admin.label.picture',
                    'template' => 'form/show/picture.html.twig',
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
                'history',
                null,
                [
                    'label' => 'admin.label.history',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->add(
                'generalNotes',
                null,
                [
                    'label' => 'admin.label.general_notes',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end();
    }
}
