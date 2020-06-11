<?php

namespace GarderieBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Repository\UserRepository;

class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['id'];
        $builder->add('dateGar')->add('nbenfants', EntityType::class, array(
            'class' => 'UserBundle:User',
            'query_builder' => function (UserRepository $er) use($id) {
                return $er->getUserParent($id);
            },
            'choice_label' => 'username',))
            ->add('activityType',EntityType::class, array(
            'class' => 'GarderieBundle:Activitie',
            'choice_label' => 'type',));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GarderieBundle\Entity\Reservation',
            'id' => null

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'garderiebundle_reservation';
    }


}
