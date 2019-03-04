<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Sexuality;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSexualities extends AbstractDataFixture
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
        $this->loadData('sexualities.yaml');
        foreach (array_keys($this->getData()) as $key) {
            $item = $this->getData($key);
            $sexuality = new Sexuality();
            $sexuality->setName($key);
            $manager->persist($sexuality);
            $manager->flush();
            $this->setReference('sexuality_'.$this->slugify($key), $sexuality);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
