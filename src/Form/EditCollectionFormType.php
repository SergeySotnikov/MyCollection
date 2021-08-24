<?php

namespace App\Form;

use App\Entity\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCollectionFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Name',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>true
            ])
            ->add('description', TextType::class, [
            'label'=> 'Description',
            'attr'=>[
                'class' => 'form-control'
            ],
            'required'=>true
        ])
            ->add('theme', TextType::class, [
                'label'=> 'Theme',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>true
            ])
            ->add('cover', TextType::class, [
                'label'=> 'Cover',
                'attr'=>[
                    'class' => 'form-control'
                ],
            ])
            ;

    }

    public function configureOptions(OptionsResolver  $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Collection::class,
        ]);
    }
}