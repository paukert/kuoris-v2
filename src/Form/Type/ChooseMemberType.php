<?php

namespace App\Form\Type;

use App\Entity\Member;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ChooseMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('members', EntityType::class, [
                'label' => 'Registrovaní členové',
                'class' => Member::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->addOrderBy('m.lastName', 'ASC')
                        ->addOrderBy('m.firstName', 'ASC');
                },
                'placeholder' => 'Vyber člena',
            ])
            ->add('editMember', SubmitType::class, [
                'label' => 'Upravit vybraného člena',
            ])
            ->add('loginAsMember', SubmitType::class, [
                'label' => 'Přihlásit se jako vybraný člen',
            ]);
    }
}
