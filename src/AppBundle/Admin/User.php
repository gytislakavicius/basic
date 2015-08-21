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
            ->add('enabled', 'checkbox', ['label' => 'Enabled', 'required' => false])
            ->add('username', 'text', ['label' => 'Username'])
            ->add('fullName', 'text', ['label' => 'Full name'])
            ->add('photoUrl', 'text', ['label' => 'Photo URL'])
            ->add('email', 'text', ['label' => 'Email'])
            ->add('plainPassword', 'password', ['label' => 'Password', 'required' => false])
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('enabled', null, ['editable' => true])
            ->add('photoUrl', null, ['template' => 'AppBundle:Admin:user_image.html.twig'])
            ->addIdentifier('username')
            ->add('fullName')
        ;
    }
}
