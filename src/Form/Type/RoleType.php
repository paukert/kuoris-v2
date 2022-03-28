<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder->addModelTransformer(
            new CallbackTransformer(
                fn($rolesAsArray) => $rolesAsArray[0] ?? null,
                fn($rolesAsString) => [$rolesAsString]
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [
                'Uživatel' => 'ROLE_USER',
                'Trenér' => 'ROLE_TRAINER',
                'Administrátor' => 'ROLE_ADMIN',
            ],
            'label' => 'Role',
            'expanded' => true,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
