<?php

namespace App\Admin\Mapper;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

/** @ignore check https://symfony.com/doc/current/form/data_mappers.html */
class ProjectsMapper implements DataMapperInterface
{
    public function mapDataToForms($data, $forms)
    {
        /** @var ArrayCollection $data */
        if (null === $data) {
            return null;
        }

        if (false === ($data instanceof ArrayCollection) && false === ($data instanceof PersistentCollection)) {
            throw new UnexpectedTypeException($data, ArrayCollection::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);
        $forms['projects']->setData($data->toArray());
    }

    public function mapFormsToData($forms, &$data)
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        if (true === empty($forms['projects']->getData())) {
            $data = null;

            return;
        }

        $data = new ArrayCollection($forms['projects']->getData());
    }
}
