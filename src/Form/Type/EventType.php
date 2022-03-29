<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Event;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('name', TextType::class, [
                'label' => 'Název události',
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Datum a čas začátku události',
                'widget' => 'single_text',
            ])
            ->add('location', TextType::class, [
                'label' => 'Místo (adresa)',
            ])
            ->add('entryDeadline', DateTimeType::class, [
                'label' => 'Uzávěrka přihlášek',
                'widget' => 'single_text',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Další popis',
                'required' => false,
            ])
            ->add('isCancelled', CheckboxType::class, [
                'label' => 'Zrušeno',
                'required' => false,
            ])
            ->add('categoriesInDatabase', EntityType::class, [
                'label' => 'Existující kategorie',
                'class' => Category::class,
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('categories')
                        ->where('categories.orisId IS NULL')
                        ->orderBy('categories.name', 'ASC');
                },
                'choice_label' => fn(Category $category) => $category->getName(),
            ])
            ->add('categories', CollectionType::class, [
                'label' => 'Kategorie',
                'entry_type' => CategoryType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
