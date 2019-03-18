<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Type\MarkDownType;
use App\Entity\Location;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class LocationAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'writing_location';
    protected $baseRoutePattern = 'writing/location';
    protected $datagridValues = [
        '_sort_by'=> 'name',
        '_sort_order'=> 'ASC',
        '_per_page'=> 512,
    ];
    protected $maxPerPage = 512;
    protected $perPageOptions = [64, 128, 256, 512];
    protected $translationDomain = 'location';

    public function preUpdate($object)
    {
        /** @var Location $object */
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
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add(
                'picture',
                null,
                [
                    'label' => 'admin.label.picture',
                    'template' => 'form/list/picture.html.twig',
                ]
            )
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('slug', null, ['label' => 'admin.label.slug'])
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                    'template' => 'form/list/markdown.html.twig',
                ]
            )
            ->add(
                'history',
                null,
                [
                    'label' => 'admin.label.history',
                    'template' => 'form/list/markdown.html.twig',
                ]
            )
            ->add(
                'generalNotes',
                null,
                [
                    'label' => 'admin.label.general_notes',
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
            ->add('uploadedPicture', FileType::class, $pictureUploadedOptions)
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('description', MarkDownType::class, ['label' => 'admin.label.description'])
            ->add('history', MarkDownType::class, ['label' => 'admin.label.history'])
            ->add('generalNotes', MarkDownType::class, ['label' => 'admin.label.general_notes']);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('slug', null, ['label' => 'admin.label.slug'])
            ->add(
                'picture',
                null,
                [
                    'label' => 'admin.label.picture',
                    'template' => 'form/show/picture.html.twig',
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
            );
    }
}
