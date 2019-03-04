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
            $item = $this->getData($key);
            $characterType = new CharacterType();

            $characterType->setName($key);
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
