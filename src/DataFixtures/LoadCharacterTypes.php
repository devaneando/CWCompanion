<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\CharacterType;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCharacterTypes extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 6;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('character_types.yaml');
        foreach (array_keys($this->getData()) as $key) {
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);
            $characterType = new CharacterType();

            $characterType
                ->setName($key)
                ->setPredefined($item['predefined']);
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $characterType->setDescription($description);
            }

            $manager->persist($characterType);
            $manager->flush();
            $this->setReference('character_type_'.$this->slugify($key), $characterType);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
