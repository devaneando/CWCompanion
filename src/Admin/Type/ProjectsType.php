<?php

namespace App\Admin\Type;

use App\Traits\LoggedUserTrait;
use App\Traits\Repository\ProjectRepositoryTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Entity\Project;

class ProjectsType extends EntityType
{
    use LoggedUserTrait;
    use ProjectRepositoryTrait;

    protected function getProjects(): array
    {
        return $this->getProjectRepository()->getProjectArrayByOwner($this->getLoggedUser());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Project::class,
            'multiple' => true,
            'empty_data' => null,
        ]);

        if (false === $this->getLoggedUser()->isSuperAdmin()) {
            $resolver->setDefault('query_builder', function (Options $options) {
                return function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('pro')
                        ->orderBy('pro.name', 'ASC')
                        ->andWhere('pro.owner = :owner')
                        ->setParameter('owner', $this->getLoggedUser());
                };
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'projects';
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
