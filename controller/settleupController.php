<?php

require_once __DIR__ . '/../model/balanceservice.class.php';
require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../app/database/db.class.php';

class SettleupController
{
    public function index()
    {
        $korisnik_overview = '';
        $bs = new BalanceService();
        list($transakcije, $imena_clanova) = $bs->settleDebts();

        require_once __DIR__ . '/../view/settleup_index.php';
    }

};