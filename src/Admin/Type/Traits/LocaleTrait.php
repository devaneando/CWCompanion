<?php

namespace App\Admin\Type\Traits;

trait LocaleTrait
{
    /** @var string */
    private $locale;

    /** @return string */
    public function getLocale()
    {
        return $this->locale;
    }

    /** @param string $locale */
    public function setLocale($locale)
    {
        $this->locale = trim($locale);
    }
}
