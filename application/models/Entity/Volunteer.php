<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Volunteer
 *
 * @Table(name="volunteer")
 * @Entity
 */
class Volunteer
{
    /**
     * @var integer $volunteerId
     *
     * @Column(name="volunteer_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $volunteerId;

    /**
     * @var string $skill
     *
     * @Column(name="skill", type="string", length=25, nullable=false)
     */
    private $skill;

    /**
     * @var Person
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumns({
     *   @JoinColumn(name="volunteer_id", referencedColumnName="person_id")
     * })
     */
    private $volunteer;


}