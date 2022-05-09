<?php

namespace App\Form\Type;

use App\Entity\Announcement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseAnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('announcements', EntityType::class, [
                'label' => 'Existující oznámení',
                'class' => Announcement::class,
                'choices' => $options['announcements'],
                'choice_label' => 'label',
                'placeholder' => 'Vyber oznámení',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'announcements' => [],
        ]);
    }
}
