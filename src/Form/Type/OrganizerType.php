<?php

namespace App\Form\Type;

use App\Entity\Organizer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder->add('name', TextType::class, [
            'label' => 'Jméno',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organizer::class,
        ]);
    }
}
