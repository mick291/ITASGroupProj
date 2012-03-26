<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Nurse
 *
 * @Table(name="nurse")
 * @Entity
 */
class Nurse
{
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
     * @ManyToOne(targetEntity="Employee")
     * @JoinColumns({
     *   @JoinColumn(name="nurse_id", referencedColumnName="employee_id")
     * })
     */
    private $nurse;

    /**
     * @var CareCenter
     *
     * @ManyToOne(targetEntity="CareCenter")
     * @JoinColumns({
     *   @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     * })
     */
    private $careCenter;

     public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}