<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nurse
 *
 * @Table(name="nurse")
 * @Entity
 */
class Nurse {

    /**
     * @var integer $nurseId
     *
     * @Column(name="nurse_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $nurseId;

    /**
     * @var string $certificate
     *
     * @Column(name="certificate", type="string", length=10, nullable=false)
     */
    private $certificate;

    /**
     * @var Employee
     *
     * @ManyToOne(targetEntity="Employee")
     * @JoinColumns({
     *   @JoinColumn(name="nurse_id", referencedColumnName="employee_id")
     * })
     */
    private $nurse;

    public function __construct($cert, $address, $dob, $fn, $ln, $email, $phone, $zip, $employee) {

        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
         

        $emp = new \Entity\Employee($address, $dob, $fn, $ln, $email, $phone, $zip, $physician = 0, $employee, $volunteer = 0, $patient = 0);
        
        $this->nurse = $emp;
        $this->certificate = $cert;
        

        $this->_entityManager->persist($this);
        $this->_entityManager->flush();
    }

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}