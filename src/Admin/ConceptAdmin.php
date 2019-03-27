<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Type\MarkDownType;
use App\Entity\Concept;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class ConceptAdmin extends AbstractExtraActionsAdmin
{
    protected $baseRouteName = 'writing_concept';
    protected $baseRoutePattern = 'writing/concept';
    protected $translationDomain = 'concept';

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('preview', $this->getRouterIdParameter().'/preview/{type}', ['type' => 'html']);
    }

    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);
        if (in_array($action, ['show', 'list']) && $object) {
            $list['preview'] = [
                'template' => 'Button/preview_button.html.twig',
            ];
        }

        return $list;
    }

    public function preUpdate($object)
    {
        /** @var Concept $object */
        if (null === $object->getUploadedPicture() && null === $object->getPicture()) {
            $object->setDefaultPicture();
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
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('slug', null, ['label' => 'admin.label.slug']);
    }

    protected function configureListFields(ListMapper $listMapper): void
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
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'list'=> ['template' => 'CRUD/list__action_preview.html.twig'],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $pictureUploadedOptions = [
            'required'=> false,
            'data_class'=> null,
            'label'=> 'admin.label.uploaded_picture',
        ];
        if (($subject = $this->getSubject()) && $subject->getPicture()) {
            $path = $subject->getPicture();
            $pictureUploadedOptions['help'] = '<img id="member-edit-picture" src="'.$path.'" style=" max-height: 250px;"/>';
        }
        $formMapper
            ->with('bl_001', ['class'=> 'col-md-6', 'label'=> 'admin.block.bl_001'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('parent', null, ['label' => 'admin.label.parent'])
            ->end()
            ->with('bl_002', ['class'=> 'col-md-6', 'label'=> 'admin.block.bl_002'])
            ->add('uploadedPicture', FileType::class, $pictureUploadedOptions)
            ->end()
            ->with('bl_003', ['class'=> 'col-md-12', 'label'=> 'admin.block.bl_002'])
            ->add('content', MarkDownType::class, ['label' => 'admin.label.content', 'rows' => 30])
            ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with('bl_001', ['class'=> 'col-md-6', 'label'=> 'admin.block.bl_001'])
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('slug', null, ['label' => 'admin.label.slug'])
            ->end()
            ->with('bl_002', ['class'=> 'col-md-6', 'label'=> 'admin.block.bl_002'])
            ->add(
                'picture',
                null,
                [
                    'label' => 'admin.label.picture',
                    'template' => 'form/show/picture.html.twig',
                ]
            )
            ->end()
            ->with('bl_003', ['class'=> 'col-md-12', 'label'=> 'admin.block.bl_002'])
            ->add(
                'content',
                null,
                [
                    'label' => 'admin.label.content',
                    'template' => 'form/show/markdown.html.twig',
                ]
            )
            ->end();
    }
}
