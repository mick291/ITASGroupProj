<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Treatment
 *
 * @Table(name="treatment")
 * @Entity
 */
class Treatment
{
    /**
     * @var integer $physicianPhysicianId
     *
     * @Column(name="physician_physician_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $physicianPhysicianId;

    /**
     * @var integer $patientPatientId
     *
     * @Column(name="patient_patient_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $patientPatientId;

    /**
     * @var integer $treatmentsTreatmentId
     *
     * @Column(name="treatments_treatment_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $treatmentsTreatmentId;

    /**
     * @var date $treatmentDate
     *
     * @Column(name="treatment_date", type="date", nullable=false)
     */
    private $treatmentDate;

    /**
     * @var time $treatmentTime
     *
     * @Column(name="treatment_time", type="time", nullable=false)
     */
    private $treatmentTime;

    /**
     * @var string $result
     *
     * @Column(name="result", type="string", length=45, nullable=false)
     */
    private $result;

    /**
     * @var Patient
     *
     * @ManyToOne(targetEntity="Patient")
     * @JoinColumns({
     *   @JoinColumn(name="patient_patient_id", referencedColumnName="patient_id")
     * })
     */
    private $patientPatient;

    /**
     * @var Physician
     *
     * @ManyToOne(targetEntity="Physician")
     * @JoinColumns({
     *   @JoinColumn(name="physician_physician_id", referencedColumnName="physician_id")
     * })
     */
    private $physicianPhysician;

    /**
     * @var Treatments
     *
     * @ManyToOne(targetEntity="Treatments")
     * @JoinColumns({
     *   @JoinColumn(name="treatments_treatment_id", referencedColumnName="treatment_id")
     * })
     */
    private $treatmentsTreatment;


}