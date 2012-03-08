<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Laboratory
 *
 * @Table(name="laboratory")
 * @Entity
 */
class Laboratory
{
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
     * @ManyToMany(targetEntity="Technician", inversedBy="laboratoryLaboratory")
     * @JoinTable(name="laboratory_has_technician",
     *   joinColumns={
     *     @JoinColumn(name="laboratory_laboratory_id", referencedColumnName="laboratory_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="technician_technician_id", referencedColumnName="technician_id")
     *   }
     * )
     */
    private $technicianTechnician;

    /**
     * @var CareCenter
     *
     * @ManyToOne(targetEntity="CareCenter")
     * @JoinColumns({
     *   @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     * })
     */
    private $careCenter;

    public function __construct()
    {
        $this->technicianTechnician = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}