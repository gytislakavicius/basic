<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class Question
 **/
class Question extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Question')
                ->add('text', 'text', array('label' => 'Question'))
                ->add('type', 'text', array('label' => 'Type'))
                ->add('difficulty', 'number', array('label' => 'Dificulty'))
            ->end()
            ->with('Answers')
                ->add('answers', 'entity', ['class' => 'AppBundle\Entity\Answer'])
            ->end()
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('text')
        ;
    }
}
