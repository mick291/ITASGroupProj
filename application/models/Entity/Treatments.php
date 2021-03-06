<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Treatments
 *
 * @Table(name="treatments")
 * @Entity
 */
class Treatments {

    /**
     * @var integer $treatmentId
     *
     * @Column(name="treatment_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $treatmentId;

    /**
     * @var string $name
     *
     * @Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

}