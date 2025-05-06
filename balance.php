<?php

require_once 'crtaj_html.php';

if(isset($_SESSION['user']))
{
    setcookie('user', $_SESSION['user'], time()+60*60*24);
}

if(!isset($_COOKIE['user'])){
	header('Location: index.php');
}
// Provjeri je li postavljena varijabla rt; kopiraj ju u $route
if( isset( $_GET['rt'] ) )
	$route = $_GET['rt'];
else
	$route = 'balance';

// Ako je $route == 'con/act', onda rastavi na $controllerName='con', $action='act'
$parts = explode( '/', $route );

$controllerName = $parts[0] . 'Controller';
if( isset( $parts[1] ) )
	$action = $parts[1];
else
	$action = 'index';

// Controller $controllerName se nalazi poddirektoriju controller
$controllerFileName = 'controller/' . $controllerName . '.php';

// Includeaj tu datoteku
if( !file_exists( $controllerFileName ) )
{
	$controllerName = '_404Controller';
	$controllerFileName = 'controller/' . $controllerName . '.php';
}

require_once $controllerFileName;

// Stvori pripadni kontroler
$con = new $controllerName; 

// Ako u njemu nema tražene akcije, stavi da se traži akcija index
if( !method_exists( $con, $action ) )
	$action = 'index';

// Pozovi odgovarajuću akciju
$con->$action();


function error_404()
{
    require_once __DIR__ . '/controller/_404Controller.php';
    $con = new _404Controller();
    $con->index();
    exit(0);
}

?>