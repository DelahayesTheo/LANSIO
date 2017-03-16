<?php
namespace ParticipantBundle\Form\Type;

use AdminBundle\Repository\EquipmentRepository;
use ParticipantBundle\Entity\bringedEquipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class bringedEquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', TextType::class)
            ->add('equipment', EntityType::class, array(
                    'class' => 'AdminBundle:Equipment',
                    'query_builder' => function(EquipmentRepository $er) {
                        return $er->queryFindAllEquipment();
                    },
                    'choice_label' => 'equipmentType',
                    'choice_value' => 'id',
                    'group_by'=> 'platform'
                )
            )
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => bringedEquipment::class,
        ));
    }
}