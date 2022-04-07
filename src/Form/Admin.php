<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Member;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class Admin extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('events', EntityType::class, [
                'label' => 'Události',
                'class' => Event::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->andWhere('e.date > :now')
                        ->setParameter('now', new \DateTime('now'))
                        ->orderBy('e.name', 'ASC');
                },
            ])
            ->add('editEvent', SubmitType::class, [
                'label' => 'Upravit vybranou událost',
            ])
            ->add('members', EntityType::class, [
                'label' => 'Členové',
                'class' => Member::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->addOrderBy('m.lastName', 'ASC')
                        ->addOrderBy('m.firstName', 'ASC');
                },
            ])
            ->add('editMember', SubmitType::class, [
                'label' => 'Upravit vybraného člena',
            ]);
    }
}
