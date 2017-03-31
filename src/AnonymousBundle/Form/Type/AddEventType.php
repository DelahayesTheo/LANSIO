<?php

namespace AnonymousBundle\Form\Type;

use AdminBundle\Repository\GameRepository;
use AnonymousBundle\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('comment', TextType::class)
            ->add('password', TextType::class)
            ->add('nbPlayersMax', IntegerType::class)
            ->add('game', EntityType::class, array(
                    'class' => 'AdminBundle:Game',
                    'query_builder' => function (GameRepository $er) {
                        return $er->queryFindAllGame();
                    },
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'group_by' => 'kind',
                    'empty_data' => null,
                    'required' => false
                )
            )
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Event::class,
        ));
    }
}