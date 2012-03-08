<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Patient
 *
 * @Table(name="patient")
 * @Entity
 */
class Patient
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
     * @var string $contactDate
     *
     * @Column(name="contact_date", type="string", length=45, nullable=false)
     */
    private $contactDate;

    /**
     * @var string $patientType
     *
     * @Column(name="patient_type", type="string", length=1, nullable=false)
     */
    private $patientType;

    /**
     * @var ItemConsumed
     *
     * @ManyToMany(targetEntity="ItemConsumed", inversedBy="patientPatient")
     * @JoinTable(name="patient_has_item_consumed",
     *   joinColumns={
     *     @JoinColumn(name="patient_patient_id", referencedColumnName="patient_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="item_consumed_item_item_id", referencedColumnName="item_item_id")
     *   }
     * )
     */
    private $itemConsumedItemItem;

    /**
     * @var Physician
     *
     * @ManyToMany(targetEntity="Physician", inversedBy="patientPatient")
     * @JoinTable(name="referral",
     *   joinColumns={
     *     @JoinColumn(name="patient_patient_id", referencedColumnName="patient_id")
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="physicians_physician_id", referencedColumnName="physician_id")
     *   }
     * )
     */
    private $physiciansPhysician;

    /**
     * @var Physician
     *
     * @ManyToOne(targetEntity="Physician")
     * @JoinColumns({
     *   @JoinColumn(name="assigned_physician", referencedColumnName="physician_id")
     * })
     */
    private $assignedPhysician;

    /**
     * @var Person
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumns({
     *   @JoinColumn(name="patient_id", referencedColumnName="person_id")
     * })
     */
    private $patient;

    public function __construct()
    {
        $this->itemConsumedItemItem = new \Doctrine\Common\Collections\ArrayCollection();
    $this->physiciansPhysician = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
      public function __get($property) 
    { 
        return $this->$property; 
    } 
    public function __set($property, $value) 
    { 
        $this->$property = $value; 
    } 
}