<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\LocationType;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLocationTypes extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 12;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('location_types.yaml');
        foreach (array_keys($this->getData()) as $key) {
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);
            $locationType = new LocationType();

            $locationType
                ->setName($key)
                ->setPredefined($item['predefined']);
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $locationType->setDescription($description);
            }

            $manager->persist($locationType);
            $manager->flush();
            $this->setReference('location_type_'.$this->slugify($key), $locationType);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
