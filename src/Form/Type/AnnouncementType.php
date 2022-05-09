<?php

namespace App\Form\Type;

use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('headline', TextType::class, [
                'label' => 'Titulek',
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Text',
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('publishedAt', DateTimeType::class, [
                'label' => 'Datum zveřejnění',
                'widget' => 'single_text',
                'help' => 'Uvedené datum bude viditelné u oznámení na hlavní stránce. Z principu by mělo korespondovat s datem vytvoření oznámení, avšak je možné ho jakkoliv přenastavit dle potřeby.'
            ])
            ->add('isVisible', CheckboxType::class, [
                'label' => 'Viditelné na hlavní stránce',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
