<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Entry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('category', EntityType::class, [
                'label' => 'Kategorie',
                'class' => Category::class,
                'choices' => $options['categories'],
                'choice_label' => 'name',
                'placeholder' => 'Vyber jednu z kategorií',
            ])
            ->add('car', CheckboxType::class, [
                'label' => 'Mohu vzít auto',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entry::class,
            'categories' => [],
        ]);
    }
}
