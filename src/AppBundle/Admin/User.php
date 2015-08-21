<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class User
 **/
class User extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', 'text', array('label' => 'User'))
            ->add('user', 'entity', array('class' => 'AppBundle\Entity\User'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('photoUrl', null, ['template' => 'AppBundle:Admin:user_image.html.twig'])
            ->addIdentifier('username')
            ->add('fullName')
        ;
    }
}
