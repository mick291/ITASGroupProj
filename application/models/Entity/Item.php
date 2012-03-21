<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @Table(name="item")
 * @Entity
 */
class Item
{
    /**
     * @var integer $itemId
     *
     * @Column(name="item_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $itemId;

    /**
     * @var string $description
     *
     * @Column(name="description", type="string", length=45, nullable=false)
     */
    private $description;

    /**
     * @var string $unitCost
     *
     * @Column(name="unit_cost", type="string", length=45, nullable=false)
     */
    private $unitCost;


}