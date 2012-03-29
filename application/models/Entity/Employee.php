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
     * @var Person
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumns({
     *   @JoinColumn(name="employee_id", referencedColumnName="person_id")
     * })
     */
    private $employee;

    /**
     * @var CareCenter
     *
     * @ManyToOne(targetEntity="CareCenter")
     * @JoinColumns({
     *   @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     * })
     */
    private $careCenter;

//    public function __construct($address, $dob, $fn, $ln, $email, $phone, $zip, $physician = 0, $employee = 0, $volunteer = 0, $patient = 0) {
//        $this->careCenter = new \Doctrine\Common\Collections\ArrayCollection();
//
//        $this->_entityManager = \Zend_Registry::get('DoctrineEntityManager');
//
//        $pers = new \Entity\Person($address, $dob, $fn, $ln, $email, $phone, $zip, $physician, $employee, $volunteer, $patient);
//       
//        $this->dateHired = date("Y-m-d");
//        $this->employee = $pers;
//        $this->careCenter = $carecenter;
//
//        $this->_entityManager->persist($this);
//        $this->_entityManager->flush();
//    }

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}