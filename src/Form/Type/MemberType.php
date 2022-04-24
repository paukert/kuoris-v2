<?php

namespace App\Form\Type;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder
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
            ->add('plaintextPassword', RepeatedPasswordType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 5, minMessage: 'Heslo musí být minimálně {{ limit }} znaků dlouhé.'),
                ],
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $member = $event->getData();
            $form = $event->getForm();

            if ($member && $member->getId() !== null) {
                $form
                    ->add('plaintextPassword', RepeatedPasswordType::class, [
                        'required' => false,
                    ])
                    ->add('roles', RoleType::class)
                    ->add('sendNotification', CheckboxType::class, [
                        'label' => 'Zasílat oznámení při přidání nové události',
                        'required' => false,
                    ])
                    ->add('activeMembership', CheckboxType::class, [
                        'label' => 'Aktivní členství',
                        'required' => false,
                    ])
                    ->add('bankBalance', IntegerType::class, [
                        'label' => 'Stav klubového konta',
                        'required' => false,
                    ])
                    ->add('clubUserOrisId', IntegerType::class, [
                        'label' => 'Klubové ORIS ID',
                        'help' => 'Pozor nejedená se o „obyčejné“ ORIS ID uživatele, ale o klubové ORIS ID uživatele!',
                    ])
                    ->add('isActive', CheckboxType::class, [
                        'label' => 'Povoleno přihlášení',
                        'required' => false,
                    ]);
            }
        });

        return $builder;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
