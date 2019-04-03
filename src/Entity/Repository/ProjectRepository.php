<?php

namespace App\Entity\Repository;

use App\Entity\Project;
use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\User;
use Doctrine\DBAL\FetchMode;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProjectRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function getProjectArrayByOwner(User $owner): array
    {
        $sql = 'SELECT name, id FROM projects';
        $params = [];
        if (true === $owner->isSuperAdmin()) {
            $sql .= ' WHERE owner_id = :owner';
            $params['owner'] = $owner->getId();
        }
        $sql .= ' ORDER BY name ASC';

        $statement = $this->getEntityManager()->getConnection()->prepare($sql);
        $statement->execute($params);

        $result = [];
        foreach ($statement->fetchAll(FetchMode::ASSOCIATIVE) as $item) {
            $result[$item['name']] = $item['id'];
        }

        return $result;
    }
}
