<?php

namespace Esgi\BlogBundle\Service;

use Symfony\Bridge\Monolog\Logger;

class Computer
{
    protected $power;
    protected $logger;

    public function __construct($power, Logger $logger)
    {
        $this->power = $power;
        $this->logger = $logger;
    }

    public function addition($a, $b)
    {
        return $a + $b;
    }

    public function power($n)
    {
        $this->logger->info(sprintf('on calcule %s puissance %s', $n, $this->power));

        return pow($n, $this->power);
    }
}
