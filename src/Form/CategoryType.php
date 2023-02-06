<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;


class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextareaType::class, [
                "label"=>"Nom de la catégorie",
                "required"=>false,//mettre valeur par défaut qui est ne nom de propriété à false pour le modifier
                "attr"=>[
                    "placeholder"=> "Saisir le nom de la catégorie",
                    "class"=>"border border-primary"
                ],
                "constraints"=>[
                    new NotBlank([
                        "message" => "Veuillez saisir un nom de catégorie"

                    ]),
                    new Length([
                        "min" => 5,
                        "max"=>10,
                        "minMessage" => "5 caractères min 🥲",
                        "maxMessage" => "10 caractères max 😅"
                    ])
                ]
            ])
            // ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
