<?php

require_once __DIR__ . '/../model/balanceservice.class.php';
require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../app/database/db.class.php';

class NewexpenseController
{
    public function index()
    {
        $bs = new BalanceService();
        $userList = $bs->getAllUsers();
        $poruka = '';
        $korisnik_overview = '';
        require_once __DIR__ . '/../view/newexpense_index.php';

    }

    public function ubaci()
    {
    $bs = new BalanceService();
    $userList = $bs->getAllUsers();
    $korisnik_overview = '';
    //treba nam broj osoba, provejravamo je li oznacen minimalno jedan checkbox
    $broj_osoba=0;
    if(!isset($_POST['options']) && empty($_POST['options']))
    {
        $poruka = 'Označite minimalno jedan checkbox!';
        require_once __DIR__ . '/../view/newexpense_index.php';
        return;
    }
    else{
        //Ako je barem jedan checkbox označen
        $selectedOptions = $_POST['options'];
        foreach($selectedOptions as $option)
            $broj_osoba++; //treba nam da podjelimo $_POST['cost'] $cost_part = $_POST['cost'] / $broj_osoba :)
    
        if(!isset($_POST['cost']) && !isset($_POST['description']))
        {
            $poruka = 'Trebat unijeti u oba polja, opis i cijenu!';
            require_once __DIR__ . '/../view/newexpense_index.php';
            return;
        }
        //sve je dobro mozemo dalje nastaviti 

        //treba provjeriti je li cost > 0 i sadrži li samo brojeve

        $trosak = (int) $_POST['cost'];
        $costString = (string) $trosak;

        if(!preg_match('/^[1-9]\d*$/',$costString))
        {
            $poruka = 'Unos cijene treba biti brojčan i > 0';
            require_once __DIR__ . '/../view/newexpense_index.php';
            return;
        }
        //mozemo nastaviti dalje, sada kada je sve dobro trebamo ubacivati podatke u tablice
        $id_user = $bs->getIdFromUser($_COOKIE['user']);
        $cost = $trosak; //iz $trosak = (int) $_POST['cost'];
        $opis = $_POST['description'];

        //ZA UBACIVANJE U dz2_expenses
        $bs->ubaciUExpenses($id_user, $cost, $opis);

        //moramo znati kako podijeliti $cost, tj na koliko osoba 
        $cost_part = $_POST['cost'] / $broj_osoba;
        //trebmo dohvatiti zadnji dz2_expenses id 
        $zadnji_id = $bs->getLastIdExpenses();

        //trebam pripremiti tablicu za insert
        foreach($selectedOptions as $option)
        {
            $user = preg_replace('/\s+/','',$option);
            $id_odg_korisnika = $bs->getIdFromUser($user);
            $bs->ubaciUParts($zadnji_id, $id_odg_korisnika, $cost_part);
        }

        //imamo $_POST['cost'] dodajemo tamo gdje je $_COOKIE['user'] jednak id tog usera
        //i onda za svakog kao i gore gledamo njegov id i za $cost_part povecavamo total_debt
        $db = DB::getConnection();
        //1. za total_paid
        $id_korisnik = $bs->getIdFromUser($_COOKIE['user']);
        $povecaj = $_POST['cost'];
        $bs->azurirajTotalPaid($povecaj, $id_korisnik);
        

        //2. za total_debt

        foreach($selectedOptions as $option)
        {
            $user = preg_replace('/\s+/','',$option);
            $id_korisnik = $bs->getIdFromUser($user);
            $bs->azurirajTotalDebt($cost_part, $id_korisnik);
        }
        
    }

    $poruka = 'Uspjesno ste ubacili podatke u aplikaciju!';
    require_once __DIR__ . '/../view/newexpense_index.php';
    return;
    }
};
