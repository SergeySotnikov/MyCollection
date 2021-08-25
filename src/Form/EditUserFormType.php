<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newEmail', TextType::class, [
                'label'=> 'Email',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>false,
                'mapped'=> false
            ])
            ->add('plainPassword', TextType::class, [
                'label'=> 'New password',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>false,
                'mapped'=> false
            ])
            ->add('roles', ChoiceType::class, [
                'label'=> 'Roles',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>false,
                'choices'=>array_flip([
                    'ROLE_USER'=>'ROLE_USER',
                    'ROLE_SUPER_ADMIN'=>'ROLE_SUPER_ADMIN',
                    'ROLE_ADMIN'=>'ROLE_ADMIN'
                ]),
                'multiple'=>true
            ])
            ->add('fullName', TextType::class, [
                'label'=> 'Full name',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>false
            ])
            ->add('phone', TextType::class, [
                'label'=> 'Phone',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>false
            ])
            ->add('adress', TextType::class, [
                'label'=> 'Address',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>false
            ])
            ->add('zipcode', TextType::class, [
                'label'=> 'Zip code',
                'attr'=>[
                    'class' => 'form-control'
                ],
                'required'=>false
            ])
        ;

    }

    public function configureOptions(OptionsResolver  $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}