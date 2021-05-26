<?php

namespace Helldar\Cashier\Services;

abstract class Processor
{
    public function sum(float $sum): self
    {
    }
}
