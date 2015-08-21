<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class Question
 **/
class Answer extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Answer')
                ->add('text', 'text', array('label' => 'Answer'))
                ->add('correct', 'checkbox', ['label' => 'Correct answer', 'required' => false])
            ->end()
            ->with('Questions')
                ->add('question', 'entity', ['class' => 'AppBundle\Entity\Question'])
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
