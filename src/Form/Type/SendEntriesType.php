<?php

namespace App\Form\Type;

use App\Entity\Race;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SendEntriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('racesInOris', EntityType::class, [
                'label' => 'Nadcházející závody se zadaným ORIS ID',
                'class' => Race::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->andWhere('e.date > :now')
                        ->andWhere('e.orisId IS NOT NULL')
                        ->setParameter('now', new \DateTime('now'))
                        ->orderBy('e.name', 'ASC');
                },
            ])
            ->add('username', TextType::class, [
                'label' => 'Uživatelské jméno do IS ORIS',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Heslo do IS ORIS',
            ]);
    }
}
