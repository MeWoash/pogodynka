<?php

namespace App\Form;

use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_of_measurement', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('temperature', NumberType::class, [
                'html5' => true,
            ])
            ->add('location', EntityType::class, [
                'class' => 'App\Entity\Location',
                'choice_label' => 'city',
            ])
            ->add('wind_speed', NumberType::class, [
                'html5' => true,
            ])
            ->add('humidity', NumberType::class, [
                'html5' => true,
            ])
            ->add('atm_pressure', NumberType::class, [
                'html5' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
