<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\IntelligenceQuotient;
use Doctrine\Common\Persistence\ObjectManager;

class LoadIntelligenceQuotients extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('intelligence_quotients.yaml');
        foreach (array_keys($this->getData()) as $key) {
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);
            $intelligenceQuotient = new IntelligenceQuotient();
            $intelligenceQuotient
                ->setName($key)
                ->setPredefined($item['predefined'])
                ->setMinimum($item['min'])
                ->setMaximum($item['max']);
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $intelligenceQuotient->setDescription($description);
            }
            $manager->persist($intelligenceQuotient);
            $manager->flush();
            $this->setReference('iq_'.$this->slugify($key), $intelligenceQuotient);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
