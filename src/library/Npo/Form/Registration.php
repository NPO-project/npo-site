<?php
namespace Npo\Form;

class Registration
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
                    'playerName', array(
                        'required' => true,
                        'label' => 'Spelernaam:',
                        'filters' => array('StringTrim'),
                        'validators' => array(
                            array(
                                'StringLength',
                                false,
                                array(3, 50)
                            )
                        ),
                        'decorators' => array(
                            'Errors',
                            'ViewHelper',
                            array('Label'))
                    )
                ),            
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
                            ),
                            array(
                                'Regex',
                                false,
                                array('/^\S+\@\S+\.\S+$/')
                            )
                        ),
                        'decorators' => array(
                            'Errors',
                            'ViewHelper',
                            array('Label')
                        )
                    )
                ),
                new \Zend_Form_Element_Text(
                    'name', array(
                        'required' => true,
                        'label' => 'Volledige naam:',
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
                new \Zend_Form_Element_Select(
                    'function', array(
                        'required' => true,
                        'label' => 'Functie:',
                        'filters' => array(),
                        'validators' => array(),
                        'multiOptions' => array(
                            'face' => 'Gezicht',
                            'programmer' => 'Programmeur',
                            'ambassador' => 'Ambassadeur',
                            'marketeer' => 'Marketeer',
                            'social' => 'Social Media Manager'),
                        'decorators' => array(
                            'Errors', 
                            'ViewHelper', 
                            array('Label')
                        )
                    )
                ),            
                new \Zend_Form_Element_Textarea(
                    'letter', array(
                        'required' => true,
                        'label' => 'Sollicitatie:',
                        'filters' => array(),
                        'validators' => array(
                            array(
                                'StringLength',
                                false,
                                array(3, 1000)
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
                        'label' => 'Versturen',
                        'decorators' => array('ViewHelper')
                    )
                )
            )
        );
    }

    public function createRegistration($data) 
    {
        $registration = new \Npo\Entity\Registration;

        if (!$this->isValid($data))
            throw new \Zend_Validate_Exception;

        $registration->playerName = $data['playerName'];
        $registration->email      = $data['email'];
        $registration->name       = $data['name'];
        $registration->function   = $data['function'];
        $registration->letter     = $data['letter'];

        return $registration;
    }
}
