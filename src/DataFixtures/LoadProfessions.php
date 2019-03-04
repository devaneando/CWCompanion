<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Profession;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProfessions extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('professions.yaml');
        foreach (array_keys($this->getData()) as $key) {
            $profession = new Profession();
            $profession->setName($key);
            $manager->persist($profession);
            $manager->flush();
            $this->setReference('profession_'.$this->slugify($key), $profession);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
