<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Outpatient
 *
 * @Table(name="outpatient")
 * @Entity
 */
class Outpatient
{
    /**
     * @var integer $patientId
     *
     * @Column(name="patient_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $patientId;

    /**
     * @var Patient
     *
     * @ManyToOne(targetEntity="Patient")
     * @JoinColumns({
     *   @JoinColumn(name="patient_id", referencedColumnName="patient_id")
     * })
     */
    private $patient;


}