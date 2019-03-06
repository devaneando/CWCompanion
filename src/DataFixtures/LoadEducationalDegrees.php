<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\EducationalDegree;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEducationalDegrees extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 7;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('educational_degrees.yaml');
        foreach (array_keys($this->getData()) as $key) {
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);
            $educationalDegree = new EducationalDegree();
            $educationalDegree
                ->setName($key)
                ->setPredefined($item['predefined']);
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $educationalDegree->setDescription($description);
            }
            $manager->persist($educationalDegree);
            $manager->flush();
            $this->setReference('educational_degree_'.$this->slugify($key), $educationalDegree);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
