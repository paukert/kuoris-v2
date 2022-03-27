<?php

namespace App\Form\Type;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('firstName', TextType::class, [
                'label' => 'Křestní jméno',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Příjmení',
            ])
            ->add('registration', TextType::class, [
                'label' => 'Registrační číslo',
                'help' => 'Registrační číslo lze nalézt na stránkách klubu (<a href="https://www.kobusti.cz/klub/" target="_blank">https://www.kobusti.cz/klub/</a>)',
                'help_html' => true,
            ])
            ->add('mail', EmailType::class, [
                'label' => 'E-mail',
            ])
            ->add('plaintextPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Zadaná hesla se neshodují.',
                'required' => true,
                'mapped' => false,
                'first_options' => ['label' => 'Heslo'],
                'second_options' => ['label' => 'Kontrola hesla'],
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 5, minMessage: 'Heslo musí být minimálně {{ limit }} znaků dlouhé.'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
