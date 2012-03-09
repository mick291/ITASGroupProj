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
     * @var integer $laboratoriesId
     *
     * @Column(name="laboratories_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $laboratoriesId;

    /**
     * @var Technician
     *
     * @ManyToMany(targetEntity="Technician", mappedBy="laboratories")
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

    public function __construct()
    {
        $this->technician = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}