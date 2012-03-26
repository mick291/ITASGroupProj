<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Treatment
 *
 * @Table(name="treatment")
 * @Entity
 */
class Treatment {

    /**
     * @var integer $physicianId
     *
     * @Column(name="physician_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $physicianId;

    /**
     * @var integer $patientId
     *
     * @Column(name="patient_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $patientId;

    /**
     * @var integer $treatmentId
     *
     * @Column(name="treatment_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $treatmentId;

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
     * @Column(name="result", type="string", length=25, nullable=false)
     */
    private $result;

    /**
     * @var Physician
     *
     * @ManyToOne(targetEntity="Physician")
     * @JoinColumns({
     *   @JoinColumn(name="physician_id", referencedColumnName="physician_id")
     * })
     */
    private $physician;

    /**
     * @var Patient
     *
     * @ManyToOne(targetEntity="Patient")
     * @JoinColumns({
     *   @JoinColumn(name="patient_id", referencedColumnName="patient_id")
     * })
     */
    private $patient;

    /**
     * @var Treatments
     *
     * @ManyToOne(targetEntity="Treatments")
     * @JoinColumns({
     *   @JoinColumn(name="treatment_id", referencedColumnName="treatment_id")
     * })
     */
    private $treatment;

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}