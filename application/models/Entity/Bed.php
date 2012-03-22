<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Bed
 *
 * @Table(name="bed")
 * @Entity
 */
class Bed
{
    /**
     * @var integer $bedId
     *
     * @Column(name="bed_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $bedId;

    /**
     * @var integer $roomNumber
     *
     * @Column(name="room_number", type="integer", nullable=false)
     */
    private $roomNumber;

    /**
     * @var CareCenter
     *
     * @ManyToOne(targetEntity="CareCenter")
     * @JoinColumns({
     *   @JoinColumn(name="care_center_id", referencedColumnName="care_center_id")
     * })
     */
    private $careCenter;

    /**
     * @var Resident
     *
     * @ManyToOne(targetEntity="Resident")
     * @JoinColumns({
     *   @JoinColumn(name="resident_patient_id", referencedColumnName="patient_id")
     * })
     */
    private $residentPatient;


}