<?php

namespace App\Form;

use App\Form\DataTransformer\TwoNumbersDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TwoNumbersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['b_must_be_non_zero'] ?? false) {
            $bConstraints[] = new NotBlank(null, 'Division by zero!');
        }

        $builder
            ->add('a', NumberType::class, ['label' => 'Value A', 'empty_data' => 0])
            ->add(
                'b',
                NumberType::class,
                [
                    'label' => 'Value B',
                    'empty_data' => 0,
                    'constraints' => $bConstraints ?? []
                ]
            )
            ->addModelTransformer(new TwoNumbersDataTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['b_must_be_non_zero' => false])
            ->setAllowedTypes('b_must_be_non_zero', 'boolean');
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}