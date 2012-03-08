<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @Table(name="person")
 * @Entity
 */
class Person
{
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
     * @Column(name="patient", type="boolean", nullable=false)
     */
    private $patient;

    /**
     * @var boolean $employee
     *
     * @Column(name="employee", type="boolean", nullable=false)
     */
    private $employee;

    /**
     * @var boolean $volunteer
     *
     * @Column(name="volunteer", type="boolean", nullable=false)
     */
    private $volunteer;

    /**
     * @var boolean $physician
     *
     * @Column(name="physician", type="boolean", nullable=false)
     */
    private $physician;

   

}