<?php

require_once 'obradi.php';
require_once 'crtaj_html.php';
require_once __DIR__ . '/app/database/db.class.php';

session_start();

//postoji ulogiran korisnik (postoji cookie)
if(isset($_COOKIE['user'])){
    require_once 'balance.php';
}
if( isset( $_POST['username'] ) )
{
	procesiraj_novi();
	exit();
}
else{
    crtaj_registerForma();
    exit();
}
    