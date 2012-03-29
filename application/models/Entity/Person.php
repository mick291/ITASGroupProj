<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @Table(name="person")
 * @Entity
 */
class Person {

    /**
     * @var integer $personId
     *
     * @Column(name="person_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $personId;

    /**
     * @var string $firstName
     *
     * @Column(name="first_name", type="string", length=45, nullable=false)
     */
    private $firstName;

    /**
     * @var string $lastName
     *
     * @Column(name="last_name", type="string", length=45, nullable=false)
     */
    private $lastName;

    /**
     * @var string $address
     *
     * @Column(name="address", type="string", length=45, nullable=false)
     */
    private $address;

    /**
     * @var string $birthDate
     *
     * @Column(name="birth_date", type="string", length=45, nullable=false)
     */
    private $birthDate;

    /**
     * @var string $phoneNumber
     *
     * @Column(name="phone_number", type="string", length=45, nullable=false)
     */
    private $phoneNumber;

    /**
     * @var string $zipCode
     *
     * @Column(name="zip_code", type="string", length=45, nullable=false)
     */
    private $zipCode;

    /**
     * @var boolean $patient
     *
     * @Column(name="patient", type="boolean", nullable=true)
     */
    private $patient;

    /**
     * @var boolean $employee
     *
     * @Column(name="employee", type="boolean", nullable=true)
     */
    private $employee;

    /**
     * @var boolean $volunteer
     *
     * @Column(name="volunteer", type="boolean", nullable=true)
     */
    private $volunteer;

    /**
     * @var boolean $physician
     *
     * @Column(name="physician", type="boolean", nullable=true)
     */
    private $physician;

    /**
     * @var string $role
     *
     * @Column(name="role", type="string", length=15, nullable=true)
     */
    private $role;

    /**
     * @var string $email
     *
     * @Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;
    
        public function __construct() {
       // $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->careCenter = new \Doctrine\Common\Collections\ArrayCollection();

//        $this->address = $address;
//        $this->birthDate = $dob;
//        $this->email = $email;
//        $this->firstName = $fn;
//        $this->lastName = $ln;
//        $this->phoneNumber = $phone;
//        $this->zipCode = $zip;
//        $this->employee = $employee;
//        $this->physician = $physician;
//        $this->volunteer = $volunteer;
//        $this->patient = $patient;
//
//        $this->_entityManager->persist($this);
//        $this->_entityManager->flush();
    }

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}