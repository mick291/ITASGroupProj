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
     * @ManyToMany(targetEntity="CareCenter", mappedBy="physician")
     */
    private $careCenter;

    /**
     * @var Patient
     *
     * @ManyToMany(targetEntity="Patient", mappedBy="physician")
     */
    private $patient;

    /**
     * @var Person
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumns({
     *   @JoinColumn(name="physician_id", referencedColumnName="person_id")
     * })
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