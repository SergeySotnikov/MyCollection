<?php

namespace App\Form;

use App\Entity\Collection;
use App\Entity\CollectionItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCollectionItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('collection', EntityType::class,[
                'label'=>'Collection',
                'required'=>true,
                'class'=>Collection::class,
                'choice_label'=>'name',
                'attr'=>[
                    'class' => 'form-control'
                ]

            ])
            ->add('name', TextType::class, [
                'label'=> 'Name',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>true
            ])
            ->add('Tag', TextType::class, [
                'label'=> 'Tag',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CollectionItem::class,
        ]);
    }
}
