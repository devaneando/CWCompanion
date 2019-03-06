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
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);
            $profession = new Profession();
            $profession
                ->setName($key)
                ->setPredefined($item['predefined']);
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $profession->setDescription($description);
            }
            $manager->persist($profession);
            $manager->flush();
            $this->setReference('profession_'.$this->slugify($key), $profession);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
