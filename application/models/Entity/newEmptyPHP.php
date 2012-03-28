<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @Table(name="employee")
 * @Entity
 */
class Employee {

    /**
     * @var integer $employeeId
     *
     * @Column(name="employee_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $employeeId;

    /**
     * @var string $dateHired
     *
     * @Column(name="date_hired", type="string", length=22, nullable=false)
     */
    private $dateHired;

    /**
     * @var CareCenter
     *
     * @ManyToMany(targetEntity="CareCenter", mappedBy="employee")
     */
    private $careCenter;

    /**
     * @var Person
     *
     * @OneToOne(targetEntity="Person")
     *   @JoinColumn(name="employee_id", referencedColumnName="person_id")
     */
    private $employee;

    public function __construct($address, $dob, $fn, $ln, $email, $phone, $zip, $physician = 0, $employee = 0, $volunteer = 0, $patient = 0) {
        $this->careCenter = new \Doctrine\Common\Collections\ArrayCollection();

        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');

        $pers = new \Entity\Person($address, $dob, $fn, $ln, $email, $phone, $zip, $physician, $employee, $volunteer, $patient);
        $this->dateHired = date("Y-m-d");
        $this->employee = $pers;
        $this->careCenter = $carecenter;
        
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


<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Physician
 *
 * @Table(name="physician")
 * @Entity
 */
class Physician
{
    /**
     * @var integer $physicianId
     *
     * @Column(name="physician_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $physicianId;

    /**
     * @var string $specialty
     *
     * @Column(name="specialty", type="string", length=45, nullable=false)
     */
    private $specialty;

    /**
     * @var string $pagerNumber
     *
     * @Column(name="pager_number", type="string", length=45, nullable=false)
     */
    private $pagerNumber;

    /**
     * @var CareCenter
     *
     * @OneToMany(targetEntity="CareCenter", mappedBy="physician")
     */
    private $careCenter;

    /**
     * @var Patient
     *
     * @OneToMany(targetEntity="Patient", mappedBy="physician")
     */
    private $patient;

    /**
     * @var Person
     *
     * @OneToOne(targetEntity="Person")
     * @JoinColumn(name="physician_id", referencedColumnName="person_id")
     */
    private $physician;

    public function __construct()
    {
        $this->careCenter = new \Doctrine\Common\Collections\ArrayCollection();
    $this->patient = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
     public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }
    
}

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

    public function __construct($address, $dob, $fn, $ln, $email, $phone, $zip, $physician = 0, $employee = 0, $volunteer = 0, $patient = 0) {
        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
        $this->careCenter = new \Doctrine\Common\Collections\ArrayCollection();

        $this->address = $address;
        $this->birthDate = $dob;
        $this->email = $email;
        $this->firstName = $fn;
        $this->lastName = $ln;
        $this->phoneNumber = $phone;
        $this->zipCode = $zip;
        $this->employee = $employee;
        $this->physician = $physician;
        $this->volunteer = $volunteer;
        $this->patient = $patient;

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
     * @var integer $certificate
     *
     * @Column(name="certificate", type="integer", nullable=false)
     */
    private $certificate;

    /**
     * @var Employee
     *
     * @ToOne(targetEntity="Employee")
     *   @JoinColumn(name="nurse_id", referencedColumnName="employee_id")
     */
    private $nurse;

    public function __construct($cert, $address, $dob, $fn, $ln, $email, $phone, $zip, $employee) {

        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');


        $emp = new \Entity\Employee($address, $dob, $fn, $ln, $email, $phone, $zip, $physician = 0, $employee, $volunteer = 0, $patient = 0);
        $this->nurse = $emp;
        $this->certificate = $cert;

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

<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Volunteer
 *
 * @Table(name="volunteer")
 * @Entity
 */
class Volunteer {

    /**
     * @var integer $volunteerId
     *
     * @Column(name="volunteer_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $volunteerId;

    /**
     * @var string $skill
     *
     * @Column(name="skill", type="string", length=25, nullable=false)
     */
    private $skill;

    /**
     * @var Person
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumns({
     *   @JoinColumn(name="volunteer_id", referencedColumnName="person_id")
     * })
     */
    private $volunteer;

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}