<?php

namespace App\Traits\Services;

use Symfony\Bridge\Monolog\Logger;

trait LoggerTrait
{
    /** @var Logger $logger */
    private $logger;

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /** @required */
    public function setLogger(Logger $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}
