<?php

namespace App\Traits\Services;

use Symfony\Component\Translation\DataCollectorTranslator;

trait TranslatorTrait
{
    /** @var DataCollectorTranslator $translator */
    private $translator;

    public function getTranslator(): DataCollectorTranslator
    {
        return $this->translator;
    }

    public function setTranslator(DataCollectorTranslator $translator): self
    {
        $this->translator = $translator;

        return $this;
    }
}
