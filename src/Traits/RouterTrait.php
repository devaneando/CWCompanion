<?php

namespace App\Traits;

use Symfony\Component\Routing\RouterInterface;

trait RouterTrait
{
    /** @var RouterInterface $router */
    private $router;

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    public function setRouter(RouterInterface $router): self
    {
        $this->router = $router;

        return $this;
    }
}
