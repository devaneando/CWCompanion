<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;

class LoadUsers extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('users.yaml');

        foreach ($this->getData() as $key => $key) {
            $item = $this->getData($key);

            /** @var User $user */
            $user = $this->getUserManager()->createUser();
            $user
                ->setUsername($item['username'])
                ->setEmail($item['email'])
                ->setPlainPassword($item['password'])
                ->setName($key)
                ->setEnabled(true)
                ->setSuperAdmin(false);
            if (true === $item['superadmin']) {
                $user->setSuperAdmin(true);
            }
            if (false === empty($item['roles'])) {
                $user->setRoles($item['roles']);
            }

            $manager->persist($user);
            $manager->flush();
            $this->setReference('user_'.$user->getUsername(), $user);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
