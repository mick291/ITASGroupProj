<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Laboratory
 *
 * @Table(name="laboratory")
 * @Entity
 */
class Laboratory {

    /**
     * @var integer $laboratoryId
     *
     * @Column(name="laboratory_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $laboratoryId;

    /**
     * @var Technician
     *
     * @ManyToMany(targetEntity="Technician", inversedBy="laboratory")
     * @JoinTable(name="laboratory_has_technician",
     *   joinColumns={
     *     @JoinColumn(name="laboratory_id", referencedColumnName="laboratory_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="technician_id", referencedColumnName="technician_id")
     *   }
     * )
     */
    private $technician;

    /**
     * @var CareCenter
     *
     * @ManyToOne(targetEntity="CareCenter")
     * @JoinColumns({
     *   @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     * })
     */
    private $careCenter;

    public function __construct() {
        $this->technician = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}