<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemConsumed
 *
 * @Table(name="item_consumed")
 * @Entity
 */
class ItemConsumed {

    /**
     * @var integer $itemId
     *
     * @Column(name="item_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $itemId;

    /**
     * @var string $date
     *
     * @Column(name="date", type="string", length=20, nullable=false)
     */
    private $date;

    /**
     * @var string $time
     *
     * @Column(name="time", type="string", length=20, nullable=false)
     */
    private $time;

    /**
     * @var string $quantity
     *
     * @Column(name="quantity", type="string", length=3, nullable=false)
     */
    private $quantity;

    /**
     * @var string $totalCost
     *
     * @Column(name="total_cost", type="string", length=10, nullable=false)
     */
    private $totalCost;

    /**
     * @var CareCenter
     *
     * @ManyToMany(targetEntity="CareCenter", mappedBy="item")
     */
    private $careCenter;

    /**
     * @var Patient
     *
     * @ManyToMany(targetEntity="Patient", mappedBy="itemConsumed")
     */
    private $patient;

    /**
     * @var Item
     *
     * @ManyToOne(targetEntity="Item")
     * @JoinColumns({
     *   @JoinColumn(name="item_id", referencedColumnName="item_id")
     * })
     */
    private $item;

    public function __construct() {
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