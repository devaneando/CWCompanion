<?php

namespace App\Twig;

use App\Entity\Character;
use App\Twig\AbstractPreviewExtension;

class CharacterExtension extends AbstractPreviewExtension
{
    public function getFilters(): array
    {
        return [
            'maybe_null' => new \Twig_SimpleFilter('maybe_null', [$this, 'getMaybeNull'], ['needs_context' => false]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            'birth_data' => new \Twig_Function('birth_data', [$this, 'getBirthData'], ['needs_context' => true]),
            'death_data' => new \Twig_Function('death_data', [$this, 'getDeathData'], ['needs_context' => true]),
            'age_data' => new \Twig_Function('age_data', [$this, 'getAgeData'], ['needs_context' => true]),
            'gender_data' => new \Twig_Function('gender_data', [$this, 'getGenderdata'], ['needs_context' => true]),
            'home_data' => new \Twig_Function('home_data', [$this, 'getHomeData'], ['needs_context' => true]),
            'occupation_data' => new \Twig_Function('occupation_data', [$this, 'getOccupationData'], ['needs_context' => true]),
            'temperament_data' => new \Twig_Function('temperament_data', [$this, 'getTemperamentData'], ['needs_context' => true]),
            'spiritual_data' => new \Twig_Function('spiritual_data', [$this, 'getSpiritualData'], ['needs_context' => true]),
            'the_character' => new \Twig_Function('the_character', [$this, 'getCharacter'], ['needs_context' => false]),
            'the_characters' => new \Twig_Function('the_characters', [$this, 'getCharacters'], ['needs_context' => false]),
        ];
    }

    public function getBirthData($context): string
    {
        /** @var Character $character */
        $character = $context['object'];

        $line = (null !== $character->getBirthCountry()) ? $character->getBirthCountry().', ' : '';
        $line .= (null !== $character->getBirthCity()) ? $character->getBirthCity().', ' : '';
        $line .= $character->getBirthdate();

        return $line;
    }

    public function getDeathData($context): string
    {
        /** @var Character $character */
        $character = $context['object'];

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
        $character = $context['object'];

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
        $character = $context['object'];

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
        $character = $context['object'];

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
        $character = $context['object'];

        $label = (true === empty($character->isCurrentOccupationNice())) ? 'text.occupation_is_not_nice' : 'text.occupation_is_nice';
        $line = $this->getTranslator()->trans('text.is', [], 'character').' '
        .$character->getCurrentOccupation().' '
        .$this->getTranslator()->trans('text.and', [], 'character').' '.$this->getTranslator()->trans($label, [], 'character');

        return $line;
    }

    public function getTemperamentData($context): string
    {
        /** @var Character $character */
        $character = $context['object'];

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
        $character = $context['object'];

        $line = (true === $character->isReligious()) ? $this->getTranslator()->trans('text.is', [], 'character') : $this->getTranslator()->trans('text.is_not', [], 'character');
        $line .= ' '.$this->getTranslator()->trans('text.religious', [], 'character').' '
            .$this->getTranslator()->trans('text.and_is', [], 'character').' '.$character->getReligion();

        return $line;
    }

    protected function getCharacterAsMarkdown(Character $character): string
    {
        return sprintf(
            '[%s](%s)',
            $character->getNickname(),
            'writing_character_preview'
        );
    }

    public function getCharacter(Character $character, $type = self::TYPE_HTML, string $class=''): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getCharacterAsMarkdown($character);
        }

        return sprintf(
            '<a class="%s" href="%s" target="_blank" alt="%s">%s</a>',
            $class,
            'writing_character_preview',
            $character->getNickname(),
            $character->getNickname()
        );
    }

    protected function getCharactersAsMarkdown($object): string
    {
        if (false === method_exists($object, 'getCharacters')) {
            return '';
        }

        if (true === empty($object->getCharacters())) {
            return '';
        }

        $list = '';
        /** @var Character $character */
        foreach ($object->getCharacters() as $character) {
            $list .= sprintf("- %s\n", $this->getCharacterAsMarkdown($character));
        }
        if (true === empty($list)) {
            $list = $this->getTranslator()->trans('text.no_character', [], 'character');
        }

        return $list;
    }

    public function getCharacters($object, $type = self::TYPE_HTML, string $class=''): string
    {
        if (self::TYPE_MARKDOWN === trim($type)) {
            return $this->getCharactersAsMarkdown($object);
        }

        if (false === method_exists($object, 'getCharacters')) {
            return '';
        }

        if (true === empty($object->getCharacters())) {
            return '';
        }

        $list = '';
        /** @var Character $character */
        foreach ($object->getCharacters() as $character) {
            $list .= sprintf("    <li>%s</li>\n", $this->getCharacter($character, self::TYPE_HTML, $class));
        }
        if (true === empty($list)) {
            $list = $this->getTranslator()->trans('text.no_character', [], 'character');
        }

        return "<ul>\n".$list."</ul>\n";
    }
}
