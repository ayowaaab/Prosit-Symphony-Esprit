<?php

namespace App\Form;

use App\Entity\Author;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',null,[
                'attr' => [
                    'placeholder' => 'Enter your Username',
                ],
            ])

            ->add('email',null,[
                'attr' => [
                    'placeholder' => 'Enter your E-mail',
                ],
            ])

            ->add('Submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
