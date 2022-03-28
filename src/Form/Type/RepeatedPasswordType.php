<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RepeatedPasswordType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'type' => PasswordType::class,
            'invalid_message' => 'Zadaná hesla se neshodují.',
            'mapped' => false,
            'first_options' => [
                'label' => 'Heslo',
                'help' => 'Heslo musí být minimálně 5 znaků dlouhé',
            ],
            'second_options' => [
                'label' => 'Kontrola hesla',
            ],
            'constraints' => [
                new Length(min: 5, minMessage: 'Heslo musí být minimálně {{ limit }} znaků dlouhé.'),
            ],
        ]);
    }

    public function getParent(): string
    {
        return RepeatedType::class;
    }
}
