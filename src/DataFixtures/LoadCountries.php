<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Country;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCountries extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 11;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('countries.yaml');
        foreach (array_keys($this->getData()) as $key) {
            $item = $this->getData($key);
            $country = new Country();
            $country
                ->setName($key)
                ->setPredefined($item['predefined'])
                ->setCode($item['code']);
            $manager->persist($country);
            $manager->flush();
            $this->setReference('country_'.$this->slugify($key), $country);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
