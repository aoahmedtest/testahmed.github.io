<?php
session_start();
if (!isset( $_SESSION['loggedin'])) $_SESSION['loggedin']=false;

/**
 * Application d'exemple Agence de voyages Silex
 */
use Symfony\Component\HttpFoundation\Request;
// require_once __DIR__.'/vendor/autoload.php';
$vendor_directory = getenv ( 'COMPOSER_VENDOR_DIR' );
if ($vendor_directory === false) {
	$vendor_directory = __DIR__ . '/vendor';
}
require_once $vendor_directory . '/autoload.php';

// Initialisations
$app = require_once 'initapp.php';

require_once 'agvoymodel.php';

function login($app,$usr,$pass)
{
    $sql = "SELECT count(*) as recnumber FROM admin WHERE login = ? and passwd = ?";
    $resultCount = $app['db']->fetchAssoc($sql, array($usr,$pass));
    if ($resultCount["recnumber"]==0) return false ; else return true;

}
// HTTP errors handling
/*$app->error(function (\Exception $e) use ($app) {
    if ($e instanceof NotFoundHttpException) {
      return $app['twig']->render('error.html.twig', array(
        'code' => '404',
      ));
    }

    $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
    return $app['twig']->render('error.html.twig', array(
      'code' => $code,
    ));
});
*/
//HOME

$app->get ( '/',
    function () use ($app)
    {
    	$circuitslist = get_all_circuits ();
    	// print_r($circuitslist);

    	return $app ['twig']->render ( 'index.html.twig', [
    			'circuitslist' => $circuitslist
    	] );
    }
)->bind ( 'home' );



// circuitlist : Liste tous les circuits
$app->get ( '/circuit',
    function () use ($app)
    {
    	$circuitslist = get_all_circuits ();
    	// print_r($circuitslist);

    	return $app ['twig']->render ( 'cruise-list.html.twig', [
    			'circuitslist' => $circuitslist
    	] );
    }
)->bind ( 'circuitlist' );


// circuitshow : affiche les détails d'un circuit
$app->get ( '/circuitid={id}',
	function ($id) use ($app)
	{
		$circuit = get_circuit_by_id ( $id );
		// print_r($circuit);
		$programmations = get_programmations_by_circuit_id ( $id );   
		//$circuit ['programmations'] = $programmations;

		return $app ['twig']->render ( 'cruise-detail.html.twig', [
				'id' => $id,
				'circuit' => $circuit
			] );
	}
)->bind ( 'circuitshow' );


// Back-office securisée par authentification
$app->get ( '/admin',
	function () use ($app)
	{
        $circuitslist = get_all_circuits ();
        if (!$_SESSION['loggedin'])
            return $app ['twig']->render ( 'auth.html.twig' , [
            'circuitslist' => $circuitslist,
            'falselogin' => false
			] );
        else 
            return $app ['twig']->render ( 'admin.html.twig', [
             /*'circuitslist' => $circuitslist,*/
            'usr' => $_SESSION['login_user']
			] );
            
	}
)->bind ( 'admin' );

$app->post('/admin', function (Request $request) use ($app) {
        $falselogin=false;
        $usr=$request->get('username');
        $pass=$request->get('password');
        $logout=$request->get('logout');
         if (isset($logout)) $_SESSION['loggedin']=false;
		 if (isset($usr) and isset($pass))
        {
            if (login($app,$request->get('username'),$request->get('password')))
            {
                $_SESSION['login_user']=$request->get('username');
                $_SESSION['loggedin']=true;
            }
             else
             {
                 $falselogin=true;
             }
        }    		
     $circuitslist = get_all_circuits ();
        if (!$_SESSION['loggedin'])
            return $app ['twig']->render ( 'auth.html.twig' , [
            'circuitslist' => $circuitslist,
            'falselogin' => $falselogin
			] );
        else 
            return $app ['twig']->render ( 'admin.html.twig', [
             /*'circuitslist' => $circuitslist,*/
            'usr' => $_SESSION['login_user']
			] );
            
});


$app->run ();





