<?php
// agvoymodel.php

/**
 * Gestion du 'modèle de données' de l'application
 */

// Définition de données d'exemple

use Model\Circuit;
use Model\ProgrammationCircuit;
use Model\UserProvider;

$list_of_circuits = array();

$circuitAndalousie = new Circuit();
$circuitAndalousie->setDescription('Andalousie');
$circuitAndalousie->setPaysDepart('Espagne');
$circuitAndalousie->addEtape('Grenade',1);
$circuitAndalousie->addEtape('Cordoue',2);
$circuitAndalousie->addEtape('Seville',1);
$list_of_circuits[] = $circuitAndalousie;

$circuitVietnam = new Circuit();
$circuitVietnam->setDescription('Vietnam');
$circuitVietnam->setPaysDepart('Vietnam');
$circuitVietnam->addEtape('Hanoï', 1);
$circuitVietnam->addEtape('Dà Nang', 1);
$circuitVietnam->addEtape('Hôï An', 1);
$circuitVietnam->addEtape('Hô Chi Minh',1);
$list_of_circuits[] = $circuitVietnam;

$circuitIdF = new Circuit();
$circuitIdF->setDescription('Ile de France');
$circuitIdF->setPaysDepart('France');
$circuitIdF->addEtape('Versailles', 1);
$circuitIdF->addEtape('Paris',1);
$list_of_circuits[] = $circuitIdF;

$circuitItalie = new Circuit();
$circuitItalie->setDescription('Italie');
$circuitItalie->setPaysDepart('Italie');
$circuitItalie->addEtape('Florence', 1);
$circuitItalie->addEtape('Sienne', 1);
$circuitItalie->addEtape('Pise', 1);
$circuitItalie->addEtape('Rome', 2);
$list_of_circuits[] = $circuitItalie;

//print_r($list_of_circuits);

// Circuits programmés

$list_of_programmations = array();

function add_programmation($date, $nb_personnes, $prix, $circuit)
{
    global $list_of_programmations;
    $programmation = new ProgrammationCircuit($date, $nb_personnes, $prix, $circuit);
    $circuit->addProgrammation($programmation);
    $list_of_programmations[] = $programmation;
}

add_programmation('2018-07-10', 10,  850, $circuitAndalousie);
add_programmation('2017-08-16', 10, 1500, $circuitVietnam);
add_programmation('2016-05-15', 12,  120, $circuitIdF);
add_programmation('2017-10-13', 15,  800, $circuitItalie);

// Fonctions utilitaires

/**
 * Renvoie tous les circuits
 * 
 * @return array
 */
function get_all_circuits()
{
    global $list_of_circuits;

    return $list_of_circuits;
}

/**
 * Récupère un circuit d'identifiant donné 
 * 
 * @param int $id
 * @return NULL|array
 */
function get_circuit_by_id($id)
{
	global $list_of_circuits;
	
	$found = null;
	
	foreach ($list_of_circuits as $circuit) {
		if ($circuit->getId() == $id) {
			$found = $circuit;
			break;
		}
	}
	return $found;
	
}

// /**
//  * Rebranche les circuits programmés sur leurs circuits
//  * 
//  * @param &array $programmation
//  */
// function join_programmation_to_circuit(&$programmation) {
//     $circuit = get_circuit_by_id($programmation['circuitId']);
//     $programmation['circuit'] = $circuit;
// }


/**
 * Renvoie tous les circuits programmés
 * 
 * @return array
 */
function get_all_programmations()
{
    global $list_of_programmations;

    return $list_of_programmations;
}

/**
 * Récupère un circuit programmé d'identifiant de circuit programmé donné
 *
 * @param int $id
 * @return NULL|array
 */
function get_programmation_by_id($id)
{
	global $list_of_programmations;
	
	$found = null;
	
	foreach ($list_of_programmations as $programmation) {
		if ($programmation->getId() == $id) {
			$found = $programmation;
			break;
		}
	}
	
	return $found;
}

/**
 * Récupère les programmations d'un circuit d'identifiant de circuit donné
 *
 * @param int $id
 * @return NULL|array
 */
function get_programmations_by_circuit_id($id)
{
	global $list_of_programmations;
	
	$found = array();
	
	foreach ($list_of_programmations as $programmation) {
		if ($programmation->getCircuit()->getId() == $id) {
			$found[] = $programmation;
		}
	}
	return $found;
}
