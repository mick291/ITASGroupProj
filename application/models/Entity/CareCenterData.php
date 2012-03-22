<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CareCenterData
 *
 * @Table(name="care_center_data")
 * @Entity
 */
class CareCenterData {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $firstName
     *
     * @Column(name="first_name", type="string", length=25, nullable=true)
     */
    private $firstName;

    /**
     * @var string $lastName
     *
     * @Column(name="last_name", type="string", length=25, nullable=true)
     */
    private $lastName;

    /**
     * @var string $address
     *
     * @Column(name="address", type="string", length=45, nullable=true)
     */
    private $address;

    /**
     * @var string $birthDate
     *
     * @Column(name="birth_date", type="string", length=25, nullable=true)
     */
    private $birthDate;

    /**
     * @var string $phoneNumber
     *
     * @Column(name="phone_number", type="string", length=15, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string $zipCode
     *
     * @Column(name="zip_code", type="string", length=15, nullable=true)
     */
    private $zipCode;

    /**
     * @var string $dateHired
     *
     * @Column(name="date_hired", type="string", length=25, nullable=true)
     */
    private $dateHired;

    /**
     * @var string $speciality
     *
     * @Column(name="speciality", type="string", length=25, nullable=true)
     */
    private $speciality;

    /**
     * @var string $pagerNumber
     *
     * @Column(name="pager_number", type="string", length=25, nullable=true)
     */
    private $pagerNumber;

    /**
     * @var string $contactDate
     *
     * @Column(name="contact_date", type="string", length=25, nullable=true)
     */
    private $contactDate;

    /**
     * @var string $patientType
     *
     * @Column(name="patient_type", type="string", length=25, nullable=true)
     */
    private $patientType;

    /**
     * @var string $assignedPhysician
     *
     * @Column(name="assigned_physician", type="string", length=25, nullable=true)
     */
    private $assignedPhysician;

    /**
     * @var string $skill
     *
     * @Column(name="skill", type="string", length=25, nullable=true)
     */
    private $skill;

    /**
     * @var string $patient
     *
     * @Column(name="patient", type="string", length=2, nullable=true)
     */
    private $patient;

    /**
     * @var string $employee
     *
     * @Column(name="employee", type="string", length=2, nullable=true)
     */
    private $employee;

    /**
     * @var string $volunteer
     *
     * @Column(name="volunteer", type="string", length=2, nullable=true)
     */
    private $volunteer;

    /**
     * @var string $physician
     *
     * @Column(name="physician", type="string", length=2, nullable=true)
     */
    private $physician;

    /**
     * @var string $ou
     *
     * @Column(name="OU", type="string", length=15, nullable=true)
     */
    private $ou;

    /**
     * @var string $full
     *
     * @Column(name="full", type="string", length=45, nullable=true)
     */
    private $full;

    /**
     * @var string $certificate
     *
     * @Column(name="certificate", type="string", length=25, nullable=true)
     */
    private $certificate;

    /**
     * @var string $jobClass
     *
     * @Column(name="job_class", type="string", length=15, nullable=true)
     */
    private $jobClass;

    /**
     * @var string $attribute
     *
     * @Column(name="attribute", type="string", length=15, nullable=true)
     */
    private $attribute;

    /**
     * @var string $role
     *
     * @Column(name="role", type="string", length=15, nullable=true)
     */
    private $role;

    /**
     * @var string $email
     *
     * @Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}