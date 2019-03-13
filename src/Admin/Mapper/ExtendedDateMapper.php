<?php

namespace App\Admin\Mapper;

use App\Model\ExtendedDate;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

/** @ignore check https://symfony.com/doc/current/form/data_mappers.html */
class ExtendedDateMapper implements DataMapperInterface
{
    public function mapDataToForms($data, $forms)
    {
        /** @var ExtendedDate $data */
        if (null === $data) {
            return;
        }

        if (false === ($data instanceof ExtendedDate)) {
            throw new UnexpectedTypeException($data, ExtendedDate::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $forms['anno_domini']->setData($data->isAnnoDomini());
        $forms['year']->setData($data->getYear());
        $forms['month']->setData($data->getMonth());
        $forms['day']->setData($data->getDay());
    }

    public function mapFormsToData($forms, &$data)
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        if (true === empty($forms['year']->getData())
            || true === empty($forms['month']->getData())
            || true === empty($forms['day']->getData())
        ) {
            $data = null;

            return;
        }

        $timeStamp = '';
        if (null === $forms['anno_domini']->getData() || false === $forms['anno_domini']->getData()) {
            $timeStamp = '-';
        }
        $timeStamp .= $forms['year']->getData().'-'
                    .sprintf('%02d', $forms['month']->getData()).'-'
                    .sprintf('%02d', $forms['day']->getData());
        $extendedDate = new ExtendedDate($timeStamp);

        $data = $extendedDate;
    }
}
