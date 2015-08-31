<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'new',
                'password',
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Naujas slaptažodis',
                    ],
                    'translation_domain' => 'FOSUserBundle',
                ]
            )
            ->add(
                'IŠSAUGOTI SLAPTAŽODĮ',
                'submit'
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FOS\UserBundle\Form\Model\ChangePassword',
            'intention'  => 'change_password',
        ));
    }

    public function getName()
    {
        return 'fos_user_change_password';
    }
}
