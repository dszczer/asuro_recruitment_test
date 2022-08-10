<?php

namespace App\Model;

class TwoNumbers
{
    protected float $a;

    protected float $b;

    public function __construct(float $a, float $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function getA(): float
    {
        return $this->a;
    }

    public function getB(): float
    {
        return $this->b;
    }
}