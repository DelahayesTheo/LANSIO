<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('platform', EntityType::class, array(
                    'class' => 'AdminBundle:Platform',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->queryFindAllPlatformOrderByName();
                    },
                    'choice_label' => 'wording',
                    'choice_value' => 'id'
                )
            )
            ->add('equipmentType', EntityType::class, array(
                    'class' => 'AdminBundle:EquipmentType',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->queryFindAllEquipmentType();
                    },
                    'choice_label' => 'wording',
                    'choice_value' => 'id'
                )
            )
            ->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Equipment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_equipment';
    }


}
