<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * CareCenter
 *
 * @Table(name="care_center")
 * @Entity
 */
class CareCenter
{
    /**
     * @var integer $careCenterId
     *
     * @Column(name="care_center_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $careCenterId;

    /**
     * @var integer $rooms
     *
     * @Column(name="rooms", type="integer", nullable=true)
     */
    private $rooms;

    /**
     * @var string $location
     *
     * @Column(name="location", type="string", length=25, nullable=false)
     */
    private $location;

    /**
     * @var string $name
     *
     * @Column(name="name", type="string", length=25, nullable=false)
     */
    private $name;

    /**
     * @var integer $bedMax
     *
     * @Column(name="bed_max", type="integer", nullable=false)
     */
    private $bedMax;

    /**
     * @var integer $labs
     *
     * @Column(name="labs", type="integer", nullable=true)
     */
    private $labs;

    /**
     * @var string $nurseInCharge
     *
     * @Column(name="nurse_in_charge", type="string", length=25, nullable=false)
     */
    private $nurseInCharge;

    /**
     * @var Employee
     *
     * @ManyToMany(targetEntity="Employee", inversedBy="careCenter")
     * @JoinTable(name="care_center_has_employee",
     *   joinColumns={
     *     @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="employee_id", referencedColumnName="employee_id")
     *   }
     * )
     */
    private $employee;

    /**
     * @var ItemConsumed
     *
     * @ManyToMany(targetEntity="ItemConsumed", inversedBy="careCenter")
     * @JoinTable(name="care_center_has_item_consumed",
     *   joinColumns={
     *     @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="item_id", referencedColumnName="item_id")
     *   }
     * )
     */
    private $item;

    /**
     * @var Physician
     *
     * @ManyToMany(targetEntity="Physician", inversedBy="careCenter")
     * @JoinTable(name="care_center_has_physician",
     *   joinColumns={
     *     @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="physician_id", referencedColumnName="physician_id")
     *   }
     * )
     */
    private $physician;

    public function __construct()
    {
        $this->employee = new \Doctrine\Common\Collections\ArrayCollection();
    $this->item = new \Doctrine\Common\Collections\ArrayCollection();
    $this->physician = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}