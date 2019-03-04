<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Religion;
use Doctrine\Common\Persistence\ObjectManager;

class LoadReligions extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('religions.yaml');

        foreach ($this->getData() as $key => $key) {
            $religion = $this->getData($key);
            $parent = new Religion();
            $parent->setName($key);
            $manager->persist($parent);
            $manager->flush();
            $this->setReference('religion_'.$this->slugify($key), $parent);

            if (false === is_array($religion)) {
                $this->stepIt();

                continue;
            }

            foreach (array_keys($religion) as $item) {
                $child = new Religion();
                $child
                    ->setName($item)
                    ->setParent($parent);
                $manager->persist($child);
                $manager->flush();
                $this->setReference('religion_'.$this->slugify($item), $parent);
                $this->stepIt();
            }
        }
        $this->getOutput()->writeln('');
    }
}
