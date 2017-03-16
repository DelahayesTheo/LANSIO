<?php
namespace ParticipantBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;

class requireEquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('needScreen', CheckboxType::class, array( 'required' => false ))
            ->add('needMouse', CheckboxType::class, array( 'required' => false ))
            ->add('needKeyboard', CheckboxType::class, array( 'required' => false ))
            ->add('needNetworkCable', CheckboxType::class, array( 'required' => false ))
            ->add('save', SubmitType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}