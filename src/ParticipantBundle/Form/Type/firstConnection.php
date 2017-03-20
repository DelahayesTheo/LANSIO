<?php
namespace ParticipantBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use UserBundle\Entity\User;

class firstConnection extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot des passes doivent correspondre.',
                'options' => array('attr' => array('class' => 'password-field', 'translation_domain' => 'FOSUserBundle')),
                'required' => true,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('isEating', CheckboxType::class, array( 'required' => false ))
            ->add('needScreen', CheckboxType::class, array( 'required' => false ))
            ->add('needMouse', CheckboxType::class, array('required' => false))
            ->add('needKeyboard', CheckboxType::class, array('required' => false))
            ->add('needNetworkCable', CheckboxType::class, array('required' => false))
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