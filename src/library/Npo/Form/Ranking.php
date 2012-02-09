<?php
namespace Npo\Form;

class Ranking
    extends \Zend_Form
{
    public function __construct($action)
    {
        $this->setDecorators(array('FormElements', 'Form'));
        $this->setAction($action);
        $this->setMethod('post');
        $this->addElements(
            array(
                new \Zend_Form_Element_Text(
                    'find', array(
                        'required' => true,
                        'label' => 'Naam:',
                        'decorators' => array(
                            'Errors', 
                            'ViewHelper', 
                            array('Label'))
                    )
                ),
                new \Zend_Form_Element_Submit(
                    'submit', array(
                        'label' => 'Zoeken',
                        'decorators' => array('ViewHelper')
                    )
                )
            )
        );
    }
}
