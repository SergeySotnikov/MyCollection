<?php

namespace App\Form;

use App\Entity\CollectionItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCollectionItemFormType extends AbstractType
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
            ->add('Tag', TextType::class, [
                'label'=> 'Tag',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CollectionItem::class,
        ]);
    }
}
