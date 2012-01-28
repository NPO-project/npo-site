<?php
interface Application_Models_IRegistrationModel
{
    /**
     * Creates a Registration from raw data
     *
     * @param array $data
     * @return Application_Models_Registration
     */
    public function create($data);

    /**
     * Persists a new registration or changes to an existing registration
     *
     * @param Application_Models_Registration $registration
     */
    public function save($registration);

    /**
     * Deletes a registration
     *
     * @param Application_Models_Registration $registration
     */
    public function delete($registration);

    /**
     * Lists all registrations
     *
     * @return array
     */
    public function list();
}
