<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Visit
 *
 * @Table(name="visit")
 * @Entity
 */
class Visit
{
    /**
     * @var integer $visitId
     *
     * @Column(name="visit_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $visitId;

    /**
     * @var integer $outpatientPatientPatientId
     *
     * @Column(name="outpatient_patient_patient_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $outpatientPatientPatientId;

    /**
     * @var date $date
     *
     * @Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string $comment
     *
     * @Column(name="comment", type="string", length=45, nullable=true)
     */
    private $comment;

    /**
     * @var Outpatient
     *
     * @ManyToOne(targetEntity="Outpatient")
     * @JoinColumns({
     *   @JoinColumn(name="outpatient_patient_patient_id", referencedColumnName="patient_patient_id")
     * })
     */
    private $outpatientPatientPatient;


}