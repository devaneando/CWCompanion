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
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);
            $gender = new Gender();
            $gender
                ->setName($key)
                ->setCode($item['code'])
                ->setPredefined($item['predefined']);
            if (null !== $item['icon']) {
                $gender->setIcon($item['icon']);
            }
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $gender->setDescription($description);
            }
            $manager->persist($gender);
            $manager->flush();
            $this->setReference('gender_'.$this->slugify($key), $gender);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
