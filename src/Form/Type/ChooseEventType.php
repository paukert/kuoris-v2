<?php

namespace App\Form\Type;

use App\Entity\Event;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChooseEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('events', EntityType::class, [
                'label' => 'Nadcházející události',
                'class' => Event::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->andWhere('e.date > :now')
                        ->setParameter('now', new \DateTime('now'))
                        ->orderBy('e.name', 'ASC');
                },
                'placeholder' => 'Vyber událost',
            ]);
    }
}
