<?php

namespace App\Form\Type;

use App\Entity\Race;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceType extends EventType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        parent::buildForm($builder, $options);

        return $builder
            ->add('orisId', IntegerType::class, [
                'label' => 'ORIS ID',
                'help' => 'Vyplnit pouze v případě, že je závod zadaný systému ORIS',
                'required' => false,
            ])
            ->add('autoUpdate', CheckboxType::class, [
                'label' => 'Provádět automatickou kontrolu datumu uzávěrky přihlášek',
                'help' => 'V případě, že není vyplněno ORIS ID, bude toto nastavení ignorováno',
                'required' => false,
            ])
            ->add('website', UrlType::class, [
                'label' => 'Webová stránka',
                'help' => 'Pokud není vyplněno a je uvedeno ORIS ID, bude jako webová stránka uvedena stránka závodu v ORISu',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Race::class,
        ]);
    }
}
