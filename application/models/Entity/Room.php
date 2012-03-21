<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @Table(name="room")
 * @Entity
 */
class Room
{
    /**
     * @var integer $roomId
     *
     * @Column(name="room_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $roomId;

    /**
     * @var CareCenter
     *
     * @ManyToOne(targetEntity="CareCenter")
     * @JoinColumns({
     *   @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     * })
     */
    private $careCenter;


}