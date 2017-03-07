<?php
namespace ParticipantBundle\Form\Type;

use ParticipantBundle\Entity\requestAdminGame;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use AdminBundle\Repository\PlatformRepository;



class requestAdminGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('platform', EntityType::class, array(
                    'class' => 'AdminBundle:Platform',
                    'query_builder' => function(PlatformRepository $er) {
                        return $er->queryFindAllPlatformOrderByName();
                    },
                    'choice_label' => 'wording',
                    'choice_value' => 'id',
                    'multiple' => true,
                    'expanded' => true,
                )
            )
            ->add('nbMaxPlayer', IntegerType::class)
            ->add('kind', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => requestAdminGame::class,
        ));
    }
}