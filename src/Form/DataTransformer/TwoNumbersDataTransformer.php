<?php

namespace App\Form\DataTransformer;

use App\Model\TwoNumbers;
use Symfony\Component\Form\DataTransformerInterface;

class TwoNumbersDataTransformer implements DataTransformerInterface
{
    /**
     * @param TwoNumbers|null $value
     */
    public function transform($value): array
    {
        return [
            'a' => $value?->getA(),
            'b' => $value?->getB()
        ];
    }

    /**
     * @param array $value
     */
    public function reverseTransform($value): ?TwoNumbers
    {
        return new TwoNumbers($value['a'] ?? .0, $value['b'] ?? .0);
    }
}