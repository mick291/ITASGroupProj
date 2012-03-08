<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Resident
 *
 * @Table(name="resident")
 * @Entity
 */
class Resident
{
    /**
     * @var integer $patientPatientId
     *
     * @Column(name="patient_patient_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $patientPatientId;

    /**
     * @var Patient
     *
     * @ManyToOne(targetEntity="Patient")
     * @JoinColumns({
     *   @JoinColumn(name="patient_patient_id", referencedColumnName="patient_id")
     * })
     */
    private $patientPatient;


}