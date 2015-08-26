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
                ->add('text', 'text', array('label' => 'Question heading'))
                ->add('description', 'text', array('label' => 'Question description'))
                ->add('activeFrom', 'sonata_type_datetime_picker', ['label' => 'Active from', 'date_format' => 'YYYY-MM-DD HH:mm:ss'])
                ->add('activeTo', 'sonata_type_datetime_picker', ['label' => 'Active to', 'date_format' => 'YYYY-MM-DD HH:mm:ss'])
                ->add('type', 'text', array('label' => 'Type'))
                ->add('difficulty', 'number', array('label' => 'Difficulty'))
            ->end()
            ->with('Answers')
                ->add('answers', 'sonata_type_model', [
                    'by_reference' => false,
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'Choose  answers',
                    'class' => 'AppBundle\Entity\Answer'
                ])
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
