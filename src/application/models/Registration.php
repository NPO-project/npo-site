<?php

class Application_Model_Registration
{
    private $_id;
    private $_playerName;
    private $_email;
    private $_name;

    /**
     * @var DateTime
     */
    private $_date;
    private $_function;
    private $_letter;

    /**
     * @param int $id
     * @return Application_Model_Registration
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * @param string $playerName
     * @return Application_Model_Registration
     */
    public function setPlayerName($playerName)
    {
        $this->_playerName = (string) $playerName;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getPlayerName()
    {
        return $this->_playerName;
    }

    /**
     * @param string $email
     * @return Application_Model_Registration
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
    
    /**
     * @param string $name
     * @return Application_Model_Registration
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * @param string $letter
     * @return Application_Model_Registration
     */
    public function setLetter($letter)
    {
        $this->_letter = $letter;
        return $this;
    }

    /**
     * @return string
     */
    public function getLetter()
    {
        return $this->_letter;
    }
    
    /**
     * @param string $function
     * @return Application_Model_Registration
     */
    public function setFunction($function)
    {
        $this->_function = $function;
        return $this;
    }

    /**
     * @return string
     */
    public function getFunction()
    {
        return $this->_function;
    }
    
    /**
     * @param DateTime $date
     * @return Application_Model_Certificate 
     */
    public function setDate($date)
    {
        $this->_date = $dateObject;
        return $this;
    }
    
    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->_date;
    }
}

