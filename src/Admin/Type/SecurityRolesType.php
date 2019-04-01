<?php

namespace App\Admin\Type;

use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecurityRolesType extends SymfonyAbstractType
{
    /** @var array */
    private $securityRoles = [];

    /** @return array */
    public function getSecurityRoles(): array
    {
        return $this->securityRoles;
    }

    /**
     * @param array $securityRoles
     *
     * @return self
     */
    public function setSecurityRoles($securityRoles): self
    {
        $roles = [];
        foreach ($securityRoles as $key => $role) {
            $roles[$key] = $key;
        }
        $this->securityRoles = $roles;

        return $this;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => $this->getSecurityRoles(),
            'choices_as_values' => true,
            'choice_translation_domain' => false,
            'multiple' => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'security_roles';
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
