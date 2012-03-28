<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Staff
 *
 * @Table(name="staff")
 * @Entity
 */
class Staff {

    /**
     * @var integer $staffId
     *
     * @Column(name="staff_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $staffId;

    /**
     * @var string $jobClass
     *
     * @Column(name="job_class", type="string", length=25, nullable=false)
     */
    private $jobClass;

    /**
     * @var Employee
     *
     * @ManyToOne(targetEntity="Employee")
     * @JoinColumns({
     *   @JoinColumn(name="staff_id", referencedColumnName="employee_id")
     * })
     */
    private $staff;

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}