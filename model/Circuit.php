<?php
/**
 * Model\Circuit.php
 * 
 * @copyright  2015-2017 Telecom SudParis
 * @license    "MIT/X" License - cf. LICENSE file at project root
 */

namespace Model;

/**
 * Classe "Circuit" du Modèle
 *
 * Entité du Modèle qui gère les circuits pouvant être (ou ayant pu être) organisés par l'agence de voyage
 */
class Circuit
{
    // stores the number of instances created (to generate next object id)
    protected static $instances = 0;

    private $_id;
    private $description;
    private $paysDepart;
    private $villeDepart;
    private $villeArrivee;
    private $dureeCircuit;
    protected $programmations;
    private $etapes;
    private $nbEtapes;
    
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
     * Set description
     *
     * @param string $description
     *
     * @return Circuit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set paysDepart
     *
     * @param string $paysDepart
     *
     * @return Circuit
     */
    public function setPaysDepart($paysDepart)
    {
        $this->paysDepart = $paysDepart;

        return $this;
    }

    /**
     * Get paysDepart
     *
     * @return string
     */
    public function getPaysDepart()
    {
        return $this->paysDepart;
    }

    /**
     * Set villeDepart
     *
     * @param string $villeDepart
     *
     * @return Circuit
     */
    public function setVilleDepart($villeDepart)
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    /**
     * Get villeDepart
     *
     * @return string
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }

    /**
     * Set villeArrivee
     *
     * @param string $villeArrivee
     *
     * @return Circuit
     */
    public function setVilleArrivee($villeArrivee)
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    /**
     * Get villeArrivee
     *
     * @return string
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }

    /**
     * Set dureeCircuit
     *
     * @param integer $dureeCircuit
     *
     * @return Circuit
     */
    public function setDureeCircuit($dureeCircuit)
    {
        $this->dureeCircuit = $dureeCircuit;

        return $this;
    }

    /**
     * Get dureeCircuit
     *
     * @return int
     */
    public function getDureeCircuit()
    {
        return $this->dureeCircuit;
    }

    /**
     * Constructor
     */
    public function __construct($id = null)
    {
    	++self::$instances;
    	if ($id) {
    		$this->_id = $id;
    	}
    	else {
	    	// Generate ID from number of instances (safe if no decrement at destruction)
		    $this->_id = self::$instances;
    	}
	    
	    $this->programmations = array();
	    $this->etapes = array();
	    
	    // Calculated attributes
	    $this->nbEtapes = 0;
	    $this->dureeCircuit = 0;
    }
		
// 	/**
// 	 * Handle restoration from the session
// 	 */
// 	public function __wakeup() {
// 		if ($this->_id > self::$instances) {
// 			self::$instances = $this->_id;
// 		}
// 	}

    /**
     * Add programmation
     *
     * @param \Model\ProgrammationCircuit $programmation
     *
     * @return Circuit
     */
    public function addProgrammation(\Model\ProgrammationCircuit $programmation)
    {
        $this->programmations[] = $programmation;

		// normaly useless       $programmation->setCircuit($this);

        return $this;
    }

    /**
     * Get programmations
     *
     * @return array
     */
    public function getProgrammations()
    {
        return $this->programmations;
    }

    /**
     * Add etape
     *
     * @param string $nom nom de la ville étape
     * @param int $duree durée de l'étape dans cette vile
     *
     * @return Circuit
     */
    public function addEtape($nom, $duree)
    {
        $etape = new Etape();
        $etape->setVilleEtape($nom);
        $etape->setNombreJours($duree);
        
    	if($this->nbEtapes == 0) {
    		$this->villeDepart = $nom;
    	}
    	// we always add etape at the end of the circuit so lastEtape is arrival
    	$this->villeArrivee = $nom;
    	$this->nbEtapes++;
    	$etape->setNumeroEtape($this->nbEtapes);
        $etape->setCircuit($this);
        $this->etapes[] = $etape;
        $this->dureeCircuit += $duree;
        
        return $this;
    }

    /**
     * Get etapes
     *
     * @return array
     */
    public function getEtapes()
    {
        return $this->etapes;
    }

}
