<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ItemConsumed
 *
 * @Table(name="item_consumed")
 * @Entity
 */
class ItemConsumed
{
    /**
     * @var integer $itemItemId
     *
     * @Column(name="item_item_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $itemItemId;

    /**
     * @var string $date
     *
     * @Column(name="date", type="string", length=45, nullable=false)
     */
    private $date;

    /**
     * @var string $time
     *
     * @Column(name="time", type="string", length=45, nullable=false)
     */
    private $time;

    /**
     * @var string $quantity
     *
     * @Column(name="quantity", type="string", length=45, nullable=false)
     */
    private $quantity;

    /**
     * @var string $totalCost
     *
     * @Column(name="total_cost", type="string", length=45, nullable=false)
     */
    private $totalCost;

    /**
     * @var CareCenter
     *
     * @ManyToMany(targetEntity="CareCenter", mappedBy="iitem")
     */
    private $careCenter;

    /**
     * @var Patient
     *
     * @ManyToMany(targetEntity="Patient", mappedBy="itemConsumedItemItem")
     */
    private $patientPatient;

    /**
     * @var Item
     *
     * @ManyToOne(targetEntity="Item")
     * @JoinColumns({
     *   @JoinColumn(name="item_item_id", referencedColumnName="item_id")
     * })
     */
    private $itemItem;

    public function __construct()
    {
        $this->careCenter = new \Doctrine\Common\Collections\ArrayCollection();
    $this->patientPatient = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}