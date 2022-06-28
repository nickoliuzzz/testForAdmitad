<?php

namespace App\Form;

use App\Dto\StatisticDto;
use App\Dto\UrlDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType as BaseUrlType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Email;

class StatisticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userEmail', TextType::class, [
                'constraints' => [
                    new Email(),
                ]
            ])
            ->add('createdAt', TextType::class, [
                'constraints' => [
                    new DateTime('Y-m-d')
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatisticDto::class,
        ]);
    }
}
