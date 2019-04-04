<?php

namespace App\Admin\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class CollectionToArrayTransformer implements DataTransformerInterface
{
    /** Transform a Collection into an array */
    public function transform($collection): array
    {
        if (null === $collection) {
            return [];
        }

        if (false === method_exists($collection, 'toArray')) {
            return '';
        }

        return $collection->toArray();
    }

    /** Transform a Collection into an array */
    public function reverseTransform($collection): ArrayCollection
    {
        if (null === $collection) {
            return new ArrayCollection();
        }

        return new ArrayCollection($collection);
    }
}
