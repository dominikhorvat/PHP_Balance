<?php

require_once __DIR__ . '/../model/balanceservice.class.php';

class UsersController
{

    public function index()
    {
        if (!isset($_GET['id_user'])) {
            require_once __DIR__ . '/../viex/404_index.php';
            return;
        } else {
            $id_korisnik = (int) $_GET['id_user'];

            $bs = new BalanceService();

            $userExpenses = $bs->getUserExpenses($id_korisnik);

            $userParts = $bs->getUserParts($id_korisnik);

            $userTotal = $bs->getUserTotal($id_korisnik); //spremljeno koliko ukupno ima -/+

            $nameofuser = $bs->getUserUsername($id_korisnik);

            if($userTotal > 0)
                $userTotal = '+'.$userTotal;

            $korisnik_overview = '('. $nameofuser . ')';
            require_once __DIR__ . '/../view/user_index.php';
            return;
        }
    }

};



?>