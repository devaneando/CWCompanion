<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Gender;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGenders extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 8;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('genders.yaml');
        foreach (array_keys($this->getData()) as $key) {
            $gender = new Gender();
            $gender->setName($key);
            $manager->persist($gender);
            $manager->flush();
            $this->setReference('gender_'.$this->slugify($key), $gender);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
