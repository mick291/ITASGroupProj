<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Patient
 *
 * @Table(name="patient")
 * @Entity
 */
class Patient
{
    /**
     * @var integer $patientId
     *
     * @Column(name="patient_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $patientId;

    /**
     * @var string $contactDate
     *
     * @Column(name="contact_date", type="string", length=45, nullable=false)
     */
    private $contactDate;

    /**
     * @var string $patientType
     *
     * @Column(name="patient_type", type="string", length=1, nullable=false)
     */
    private $patientType;

    /**
     * @var ItemConsumed
     *
     * @ManyToMany(targetEntity="ItemConsumed", inversedBy="patient")
     * @JoinTable(name="patient_has_item_consumed",
     *   joinColumns={
     *     @JoinColumn(name="patient_id", referencedColumnName="patient_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="item_consumed_id", referencedColumnName="item_id")
     *   }
     * )
     */
    private $itemConsumed;

    /**
     * @var Physician
     *
     * @ManyToMany(targetEntity="Physician", inversedBy="patient")
     * @JoinTable(name="referral",
     *   joinColumns={
     *     @JoinColumn(name="patient_id", referencedColumnName="patient_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="physician_id", referencedColumnName="physician_id")
     *   }
     * )
     */
    private $physician;

    /**
     * @var Person
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumns({
     *   @JoinColumn(name="patient_id", referencedColumnName="person_id")
     * })
     */
    private $patient;

    /**
     * @var Physician
     *
     * @ManyToOne(targetEntity="Physician")
     * @JoinColumns({
     *   @JoinColumn(name="assigned_physician", referencedColumnName="physician_id")
     * })
     */
    private $assignedPhysician;

    public function __construct()
    {
        $this->itemConsumed = new \Doctrine\Common\Collections\ArrayCollection();
    $this->physician = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}