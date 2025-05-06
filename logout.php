<?php

session_unset();
session_destroy();

//jos moramo samo obrisat cookie
setcookie('user','',time()-1800);
//-1800 jer smo postavili na +1800 

//Kada se korisnik logouta zapocni sve ispocetka, tj. baci ga na index.php gdje
//ce se prikazati forma za login
header('Location: index.php');
exit();

?>