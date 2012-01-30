<?php

class Application_Model_RegistrationMapper
    implements Application_Model_IRegistrationModel
{
    private $_dbTable;
 
    public function list()
    {
        return $this->fetchAll();
    }

    public function save($registration)
    {
        if ($registration->id === null)
            $this->insert($registration);
        else
            $this->update($registration);
    }

    public function getDbTable()
    {
        if (!$this->_dbTable)
            $this->_dbTable = new Application_Model_DbTable_Registrations();

        return $this->_dbTable;
    }
    
    public function fetchAll()
    {
        $table = $this->getDbTable();
        $rows = $table->fetchAll();
        $data = array();

        foreach ($rows as $row) {
            $registration = new Application_Model_Registration();
            $registration->setId($row->id)
                ->setDate($row->date)
                ->setPlayerName($row->playerName)
                ->setEmail($row->email)
                ->setName($row->name)
                ->setFunction($row->function)
                ->setLetter($row->letter);

            $data[] = $registration;
        }

        return $data;
    }

    public function insert($registration)
    {
        $table = $this->getDbTable();
        $data = $this->_RegistrationToRow($registration);
        $id = $table->insert($data);

        $registration->setId($id);
    }

    public function update($registration)
    {
        $table = $this->getDbTable();
        $data = $this->_RegistrationToRow($registration);
        $where = $this->getAdapter()->quoteInto('id = ?', $data['id']);

        $table->update($data, $where);
    }

    public function delete($registration)
    {
        $table = $this->getDbTable();
        $data = $this->_registrationToRow($registration);
        $where = $this->getAdapter()->quoteInto('id = ?', $data['id']);

        $table->delete($where);
    }

    public function create($data) 
    {
        $registration = new Application_Model_Registration();
        $registration->setDate($data->date)
            ->setPlayerName($data->playerName)
            ->setEmail($data->email)
            ->setName($data->name)
            ->setFunction($data->function)
            ->setLetter($data->letter);

        return $registration;
    }

    private function _registrationToRow($registration)
    {
        return array(
            'id' => $registration->getId(),
            'date' => $registration->getDate(),
            'playerName' => $registration->getPlayerName(),
            'email' => $registration->getEmail(),
            'name' => $registration->getName(),
            'function' => $registration->getFunction(),
            'letter' => $registration->getLetter()
        );
    }
}

