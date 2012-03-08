<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @Table(name="employee")
 * @Entity
 */
class Employee
{
    /**
     * @var integer $employeeId
     *
     * @Column(name="employee_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $employeeId;

    /**
     * @var string $dateHired
     *
     * @Column(name="date_hired", type="string", length=1, nullable=false)
     */
    private $dateHired;

    /**
     * @var CareCenter
     *
     * @ManyToMany(targetEntity="CareCenter", mappedBy="employeeEmployee")
     */
    private $careCenterCareCenter;

    /**
     * @var Person
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumns({
     *   @JoinColumn(name="employee_id", referencedColumnName="person_id")
     * })
     */
    private $employee;

    public function __construct()
    {
        $this->careCenterCareCenter = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}