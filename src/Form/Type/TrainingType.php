<?php

namespace App\Form\Type;

use App\Entity\Training;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends EventType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        parent::buildForm($builder, $options);

        return $builder
            ->add('maxCapacity', IntegerType::class, [
                'label' => 'Maximální kapacita',
                'help' => 'Pro neomezenou kapacitu nech políčko prázdné',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
