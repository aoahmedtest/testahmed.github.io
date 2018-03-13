<?php

/**
 * Model\ProgrammationCircuit.php
 *
 * @copyright  2015-2017 Telecom SudParis
 * @license    "MIT/X" License - cf. LICENSE file at project root
 */

namespace Model;

use DateTime;

/**
 * Classe "Programmation d'un Circuit" du Modèle
 *
 * Entité du Modèle qui gère les programmations de circuits faites (ou ayant été faites) par l'agence de voyage
 */
class ProgrammationCircuit
{
	// stores the number of instances created (to generate next object id)
	private static $instances = 0;

	/** var int
	 * 
	 */

	private $_id;

	/**
     * @var \DateTime
     *
     */
    private $dateDepart;

    /**
     * @var int
     *
     */
    private $nombrePersonnes;

    /**
     * @var int
     *
     */
    private $prix;

    /**
     * Circuit de cette programmation
     * 
     * @var \Model\Circuit
     */
    protected $circuit;
    
	/** 
	 * Constructeur
	 * 
	 * @var string $date
	 * @var int $nbPersonnes
	 * @var int $price
	 * @var Model\Circuit $circuitAssocie
	 */
    public function __construct($date, $nbPersonnes, $price, $circuitAssocie, $id=null) {
    	++self::$instances;
    	if($id) {
    		$this->_id = $id;
    	}
    	else {
    		$this->_id = self::$instances;
    	}
    	
    	$this->dateDepart = new DateTime($date);
    	$this->nombrePersonnes = $nbPersonnes;
    	$this->prix = $price;
    	$this->circuit = $circuitAssocie;
    	//$this->circuit->addProgrammation($this);
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
    	return $this->_id;
    }

    /**
     * Set dateDepart
     *
     * @param \DateTime $dateDepart
     *
     * @return ProgrammationCircuit
     */
    public function setDateDepart($dateDepart)
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    /**
     * Get dateDepart
     *
     * @return \DateTime
     */
    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    /**
     * Set nombrePersonnes
     *
     * @param integer $nombrePersonnes
     *
     * @return ProgrammationCircuit
     */
    public function setNombrePersonnes($nombrePersonnes)
    {
        $this->nombrePersonnes = $nombrePersonnes;

        return $this;
    }

    /**
     * Get nombrePersonnes
     *
     * @return int
     */
    public function getNombrePersonnes()
    {
        return $this->nombrePersonnes;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return ProgrammationCircuit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set circuit
     *
     * @param \Model\Circuit $circuit
     *
     * @return ProgrammationCircuit
     */
    public function setCircuit(\Model\Circuit $circuit = null)
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * Get circuit
     *
     * @return \Model\Circuit
     */
    public function getCircuit()
    {
        return $this->circuit;
    }
}
