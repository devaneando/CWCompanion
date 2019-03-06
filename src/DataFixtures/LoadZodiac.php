<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Zodiac;
use Doctrine\Common\Persistence\ObjectManager;

class LoadZodiac extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadData('zodiac_signs.yaml');
        foreach (array_keys($this->getData()) as $key) {
            if (true === in_array($key, ['description', 'predefined'])) {
                continue;
            }
            $item = $this->getData($key);
            $zodiac = new Zodiac();

            $zodiac
                ->setName($key)
                ->setStart(\DateTime::createFromFormat('Y-m-d', $item['start']))
                ->setEnd(\DateTime::createFromFormat('Y-m-d', $item['end']));
            if (null !== $item['start_complementary']) {
                $zodiac->setStartComplementary(\DateTime::createFromFormat('Y-m-d', $item['start_complementary']));
            }
            if (null !== $item['end_complementary']) {
                $zodiac->setEndComplementary(\DateTime::createFromFormat('Y-m-d', $item['end_complementary']));
            }
            $description = $this->arrayToDescription($item['description']);
            if (false === empty($description)) {
                $zodiac->setDescription($description);
            }

            $manager->persist($zodiac);
            $manager->flush();
            $this->setReference('zodiac_'.$this->slugify($key), $zodiac);
            $this->stepIt();
        }
        $this->getOutput()->writeln('');
    }
}
