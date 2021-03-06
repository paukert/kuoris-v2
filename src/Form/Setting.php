<?php

namespace App\Form;

use App\Entity\Member;
use App\Form\Type\RepeatedPasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Setting extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('mail', EmailType::class, [
                'label' => 'E-mail',
            ])
            ->add('plaintextPassword', RepeatedPasswordType::class, [
                'required' => false,
            ]);
//            ->add('sendNotification', CheckboxType::class, [
//                'label' => 'Zasílat oznámení při přidání nové události',
//                'required' => false,
//            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
