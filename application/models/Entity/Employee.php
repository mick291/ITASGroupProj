<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @Table(name="employee")
 * @Entity
 */
class Employee
{
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

    public function __construct()
    {
        $this->careCenter = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
     public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }
}