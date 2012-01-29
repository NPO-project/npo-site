<?php

class Application_Model_Certificate
{

    private $_id;
    private $_playerId;
    /**
     * @var DateTime
     */
    private $_date;
    /**
     * @var DateTime
     */
    private $_endDate;
    
    /**
     * @param int $id
     * @return Application_Model_Certificate 
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
     * @param int $id
     * @return Application_Model_Certificate 
     */
    public function setPlayerId($id)
    {
        $this->_playerId = (int) $id;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getPlayerId()
    {
        return $this->_playerId;
    }
    
    /**
     * @param mixed $date
     * @return Application_Model_Certificate 
     */
    public function setDate($date)
    {
        if (is_string($date)) {
            $dateObject = new DateTime($date);
        } elseif ($date instanceof DateTime) {
            $dateObject = $date;
        } else {
            throw new InvalidArgumentException();
        }
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
    
    /**
     * @param mixed $date
     * @return Application_Model_Certificate 
     */
    public function setEndDate($date)
    {
        if (is_string($date)) {
            $dateObject = new DateTime($date);
        } elseif ($date instanceof DateTime) {
            $dateObject = $date;
        } else {
            throw new InvalidArgumentException();
        }
        $this->_endDate = $dateObject;
        return $this;
    }
    
    /**
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }
    
}

