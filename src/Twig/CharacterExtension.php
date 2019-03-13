<?php

namespace App\Twig;

use App\Entity\Character;
use App\Traits\Services\TranslatorTrait;

class CharacterExtension extends \Twig_Extension
{
    use TranslatorTrait;

    public function getFilters(): array
    {
        return [
            'maybeNull' => new \Twig_SimpleFilter('maybeNull', [$this, 'getMaybeNull'], ['needs_context' => false]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            'birthData' => new \Twig_Function('birthData', [$this, 'getBirthData'], ['needs_context' => true]),
            'deathData' => new \Twig_Function('deathData', [$this, 'getDeathData'], ['needs_context' => true]),
            'ageData' => new \Twig_Function('ageData', [$this, 'getAgeData'], ['needs_context' => true]),
            'genderdata' => new \Twig_Function('genderdata', [$this, 'getGenderdata'], ['needs_context' => true]),
            'homeData' => new \Twig_Function('homeData', [$this, 'getHomeData'], ['needs_context' => true]),
            'occupationData' => new \Twig_Function('occupationData', [$this, 'getOccupationData'], ['needs_context' => true]),
            'temperamentData' => new \Twig_Function('temperamentData', [$this, 'getTemperamentData'], ['needs_context' => true]),
            'spiritualData' => new \Twig_Function('spiritualData', [$this, 'getSpiritualData'], ['needs_context' => true]),
        ];
    }

    public function getBirthData($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        $line = (null !== $character->getBirthCountry()) ? $character->getBirthCountry().', ' : '';
        $line .= (null !== $character->getBirthCity()) ? $character->getBirthCity().', ' : '';
        $line .= $character->getBirthdate();

        return $line;
    }

    public function getDeathData($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        if (null === $character->getDateOfDeath()) {
            return '';
        }

        $line = '--';
        $line .= (null !== $character->getCountryOfDeath()) ? $character->getCountryOfDeath().', ' : '';
        $line .= (null !== $character->getCityOfDeath()) ? $character->getCityOfDeath().', ' : '';
        $line .= $character->getDateOfDeath();

        return $line;
    }

    public function getAgeData($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        return $this->getTranslator()->transChoice(
            'text.age_data',
            (int)$character->getAge(),
            ['%age%' => (int)$character->getAge()],
            'character'
        );
    }

    public function getGenderdata($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        switch ($character->getGender()->getCode()) {
            case 'm':
            case 'f':
                return $this->getTranslator()->trans(
                    'text.is_gender_defined',
                    ['%gender%' => $character->getGender()->getName()],
                    'character'
                );

                break;
            case 'u':
                return $this->getTranslator()->trans(
                    'text.is_gender_undefined',
                    ['%gender%' => $character->getGender()->getName()],
                    'character'
                );

                break;

            default:
                return $this->getTranslator()->trans(
                    'text.is_gender',
                    ['%gender%' => $character->getGender()->getName()],
                    'character'
                );

                break;
        }
    }

    public function getMaybeNull($value): string
    {
        return (true === empty($value)) ? $this->getTranslator()->trans('text.no_value', [], 'character') : $value;
    }

    public function getHomeData($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        if (true === is_null($character->getHomeCountry() && true === is_null($character->getHomeCity()))) {
            return $this->getTranslator()->trans('text.no_value', [], 'character');
        }

        $line = (false === empty($character->getHomeCountry())) ? $character->getHomeCountry() : '';
        if (false === empty($character->getHomeCity())) {
            $line = (true === empty($line)) ? $character->getHomeCity() : $character->getHomeCity().', '.$line;
        }

        return $line;
    }

    public function getOccupationData($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        $label = (true === empty($character->isCurrentOccupationNice())) ? 'text.occupation_is_not_nice' : 'text.occupation_is_nice';
        $line = $this->getTranslator()->trans('text.is', [], 'character').' '
        .$character->getCurrentOccupation().' '
        .$this->getTranslator()->trans('text.and', [], 'character').' '.$this->getTranslator()->trans($label, [], 'character');

        return $line;
    }

    public function getTemperamentData($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        $line = $this->getTranslator()->trans('text.is', [], 'character').' '.$this->getTranslator()->trans('text.mainly', [], 'character').' '.
        $character->getDominantTemperament();
        if (false === empty($character->getSecondaryTemperament())) {
            $line .= ' '.$this->getTranslator()->trans('text.but_also', [], 'character').' '.$character->getSecondaryTemperament();
        }

        return $line;
    }

    public function getSpiritualData($context): string
    {
        /** @var Character $character */
        $character = $context['character'];

        $line = (true === $character->isReligious()) ? $this->getTranslator()->trans('text.is', [], 'character') : $this->getTranslator()->trans('text.is_not', [], 'character');
        $line .= ' '.$this->getTranslator()->trans('text.religious', [], 'character').' '
            .$this->getTranslator()->trans('text.and_follows', [], 'character').' '.$character->getReligion();

        return $line;
    }
}
