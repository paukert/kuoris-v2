<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class OrisImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $builder
            ->add('orisId', IntegerType::class, [
                'label' => 'ORIS ID',
                'help' => 'ORIS ID lze nalézt na detailní stránce závodu v ORISu v sekci &bdquo;Informace&ldquo;',
                'help_html' => true,
                'mapped' => false,
                'constraints' => [
                    new Type(type: 'integer'),
                    new NotBlank(),
                ],
            ]);
    }
}
