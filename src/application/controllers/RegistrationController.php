<?php

class RegistrationController extends Zend_Controller_Action
{
    private $_form;
    private $_registrations;

    public function init()
    {
        $this->view->headTitle('Tribal Wars NPO-Manifest');
    }

    public function indexAction()
    {
        $this->view->form = $this->getForm();

        return $this->render('index');
    }

    public function registerAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();

            if ($this->getForm()->isValid($data)) {
                $registration = $this->getRegistrations()->create($data);
                $this->getRegistrations()->save($registration);

                return $this->render('verification');
            }
        }

        $this->view->form = $this->getForm();

        return $this->render('index');
    }

    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = new Zend_Form();

            $this->_form->setDecorators(array('FormElements', 'Form'));
            $this->_form->setAction('/registration/register');
            $this->_form->setMethod('post');
            $this->_form->addElements(
                array(
                    new Zend_Form_Element_Text(
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
                    new Zend_Form_Element_Text(
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
                    new Zend_Form_Element_Text(
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
                    new Zend_Form_Element_Select(
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
                    new Zend_Form_Element_Textarea(
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
                    new Zend_Form_Element_Submit(
                        'submit', array(
                            'label' => 'Versturen',
                            'decorators' => array('ViewHelper')
                        )
                    )
                )
            );
        }

        return $this->_form;
    }

    public function getRegistrations()
    {
        if (!$this->_registrations)
            $this->_registrations = new Application_Model_RegistrationMapper();

        return $this->_registrations;
    }
}

