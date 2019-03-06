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
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);

            $religion = $this->getData($key);
            $parent = new Religion();
            $parent
                ->setName($key)
                ->setPredefined($item['predefined']);
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $parent->setDescription($description);
            }
            $manager->persist($parent);
            $manager->flush();
            $this->setReference('religion_'.$this->slugify($key), $parent);

            if (false === is_array($religion)) {
                $this->stepIt();

                continue;
            }

            foreach (array_keys($religion) as $key) {
                if (true === in_array($key, ['description', 'predefined'])) {
                    continue;
                }
                $item = $religion[$key];
                $child = new Religion();
                $child
                    ->setName($key)
                    ->setParent($parent)
                    ->setPredefined($item['predefined']);
                $description = $this->arrayToDescription($item['description']);
                if (false === empty($description)) {
                    $child->setDescription($description);
                }
                $manager->persist($child);
                $manager->flush();
                $this->setReference('religion_'.$this->slugify($key), $child);
                $this->stepIt();
            }
        }
        $this->getOutput()->writeln('');
    }
}
