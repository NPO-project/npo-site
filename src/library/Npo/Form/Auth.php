<?php
namespace Npo\Form;

class Auth
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
                    'email', array(
                        'required' => true,
                        'label' => 'E-mailadres:',
                        'filters' => array('StringTrim'),
                        'validators' => array(
                            array(
                                'StringLength',
                                false,
                                array(3, 100)
                            )
                        ),
                        'decorators' => array(
                            'Errors',
                            'ViewHelper',
                            array('Label')
                        )
                    )
                ),
                new \Zend_Form_Element_Password(
                    'name', array(
                        'required' => true,
                        'label' => 'Wachtwoord:',
                        'filters' => array('StringTrim'),
                        'validators' => array(
                            array(
                                'StringLength',
                                false,
                                array(3, 100)
                            ),
                        ),
                        'decorators' => array(
                            'Errors',
                            'ViewHelper',
                            array('Label')
                        )
                    )
                ),
                new \Zend_Form_Element_Submit(
                    'submit', array(
                        'label' => 'Aanmelden',
                        'decorators' => array('ViewHelper')
                    )
                )
            )
        );
    }
}
