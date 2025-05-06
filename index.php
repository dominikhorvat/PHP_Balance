<?php
require_once 'crtaj_html.php';
require_once 'obradi.php';
require_once 'app/database/db.class.php';

session_start();

//postoji ulogiran korisnik (postoji cookie)
if(isset($_COOKIE['user'])){
    require_once 'balance.php';
}
//provjera trenutnog slanja podataka
if(isset($_POST['username'])){
    procesiraj_login();
    exit();
}
else{ 
    //korisnik nije u ulogiran niti se salje nista putem posta, ispisi mu formu za login
    crtaj_loginForma();
    exit();
}

?>