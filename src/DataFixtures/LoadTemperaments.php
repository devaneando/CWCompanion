<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Temperament;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTemperaments extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('temperaments.yaml');
        foreach (array_keys($this->getData()) as $key) {
            $item = $this->getData($key);
            $temperament = new Temperament();
            $temperament->setName($key);

            $description = null;
            if (false === empty($item['description'])) {
                foreach ($item['description'] as $line) {
                    if (true === empty($line)) {
                        $description .= "\n\n";

                        continue;
                    }
                    $description .= $line.' ';
                }
            }
            if (null !== $description) {
                $temperament->setDescription($description);
            }

            $manager->persist($temperament);
            $manager->flush();
            $this->setReference('temperament_'.$this->slugify($key), $temperament);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
