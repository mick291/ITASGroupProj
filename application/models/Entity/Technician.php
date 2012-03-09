<?php



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
     * @Column(name="skill", type="string", length=45, nullable=false)
     */
    private $skill;

    /**
     * @var Laboratory
     *
     * @ManyToMany(targetEntity="Laboratory", inversedBy="technician")
     * @JoinTable(name="technician_has_laboratories",
     *   joinColumns={
     *     @JoinColumn(name="technician_id", referencedColumnName="technician_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="laboratories_id", referencedColumnName="laboratories_id")
     *   }
     * )
     */
    private $laboratories;

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
        $this->laboratories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}