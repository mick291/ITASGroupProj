<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Technician
 *
 * @Table(name="technician")
 * @Entity
 */
class Technician
{
    /**
     * @var integer $technicianId
     *
     * @Column(name="technician_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $technicianId;

    /**
     * @var string $skill
     *
     * @Column(name="skill", type="string", length=25, nullable=false)
     */
    private $skill;

    /**
     * @var Laboratory
     *
     * @ManyToMany(targetEntity="Laboratory", mappedBy="technician")
     */
    private $laboratory;

    /**
     * @var Employee
     *
     * @ManyToOne(targetEntity="Employee")
     * @JoinColumns({
     *   @JoinColumn(name="technician_id", referencedColumnName="employee_id")
     * })
     */
    private $technician;

    public function __construct()
    {
        $this->laboratory = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}