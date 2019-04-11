<?php

declare (strict_types = 1);

namespace App\Admin;

use App\Admin\AbstractExtraActionsAdmin;
use App\Admin\Type\SecurityRolesType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractExtraActionsAdmin
{
    protected $baseRouteName = 'admin_user';
    protected $baseRoutePattern = 'admin/user';
    protected $translationDomain = 'user';

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('username', null, ['label' => 'admin.label.username'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('email', null, ['label' => 'admin.label.email'])
            ->add('enabled', null, ['label' => 'admin.label.enabled']);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('username', null, ['label' => 'admin.label.username'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('email', null, ['label' => 'admin.label.email'])
            ->add(
                'roles',
                null,
                [
                    'label' => 'admin.label.roles',
                    'template' => 'form/list/security_roles.html.twig',
                ]
            )
            ->add('enabled', null, ['label' => 'admin.label.enabled'])
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
            ->add('username', null, ['label' => 'admin.label.username'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('email', null, ['label' => 'admin.label.email'])
            ->add('salt', null, ['label' => 'admin.label.salt'])
            ->add(
                'plainPassword',
                TextType::class,
                [
                    'required' => (!$this->getSubject() || null === $this->getSubject()->getId()),
                    'label' => 'admin.label.plain_password',
                ]
            )
            ->add('roles', SecurityRolesType::class, [
                'label' => 'admin.label.roles',
                'required' => false,
            ])
            ->add('enabled', null, ['label' => 'admin.label.enabled']);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.label.id'])
            ->add('username', null, ['label' => 'admin.label.username'])
            ->add('usernameCanonical', null, ['label' => 'admin.label.username_canonical'])
            ->add('name', null, ['label' => 'admin.label.name'])
            ->add('email', null, ['label' => 'admin.label.email'])
            ->add('emailCanonical', null, ['label' => 'admin.label.email_canonical'])
            ->add('salt', null, ['label' => 'admin.label.salt'])
            ->add(
                'roles',
                null,
                [
                    'label' => 'admin.label.roles',
                    'template' => 'form/show/security_roles.html.twig',
                ]
            )
            ->add('confirmationToken', null, ['label' => 'admin.label.confirmation_token'])
            ->add('passwordRequestedAt', null, ['label' => 'admin.label.password_requested_at'])
            ->add('lastLogin', null, ['label' => 'admin.label.last_login'])
            ->add('enabled', null, ['label' => 'admin.label.enabled']);
    }
}
