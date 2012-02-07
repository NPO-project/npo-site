<?php
namespace Npo\Form;

class Member
    extends \Zend_Form
{
    public function __construct($action, $registrations)
    {
        $registrationOptions = self::_buildRegistrationOptions($registrations);

        $this->setDecorators(array('FormElements', 'Form'));
        $this->setAction($action);
        $this->setMethod('post');
        $this->addElements(
            array(
                new \Zend_Form_Element_Select(
                    'registration', array(
                        'required' => true,
                        'label' => 'Registratie:',
                        'validators' => array(),
                        'multiOptions' => $registrationOptions,
                        'decorators' => array(
                            'Errors', 
                            'ViewHelper', 
                            array('Label'))
                    )
                ),
                new \Zend_Form_Element_Text(
                    'name', array(
                        'required' => true,
                        'label' => 'Naam:',
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
                new \Zend_Form_Element_Submit(
                    'submit', array(
                        'label' => 'Opslaan',
                        'decorators' => array('ViewHelper')
                    )
                )
            )
        );
    }

    private static function _buildRegistrationOptions($registrations) 
    {
        $options = array();
        
        foreach ($registrations as $registration)
            $options[$registration->id] = $registration->name . '(' . $registration->playerName . ') : ' . $registration->function;

        return $options;
    }

    public function createMember($data, $password, $registration)
    {
        $member = new \Npo\Entity\Member;
        $role = new \Npo\Entity\Role;

        if (!$this->isValid($data))
            throw new \Zend_Validate_Exception;

        $role->role = $data['function'];
        $role->member = $member;

        $member->name     = $data['name'];
        $member->email    = $data['email'];
        $member->password = sha1($password);
        $member->roles->add($role);
        $member->registration = $registration;

        return $member;
    }
}
