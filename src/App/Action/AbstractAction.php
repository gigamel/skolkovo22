<?php

namespace App\Action;

use Skolkovo22\DI\ServicesContainer;
use Skolkovo22\Http\ActionInterface;

abstract class AbstractAction implements ActionInterface
{
    /** @var ServicesContainer */
    protected $container;

    /**
     * @param ServiceContainer $container
     */
    public function __construct(ServicesContainer $container)
    {
        $this->container = $container; 
    }
}
