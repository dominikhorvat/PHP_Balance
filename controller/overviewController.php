<?php

require_once __DIR__ .'/../model/balanceservice.class.php';

class OverviewController
{
    public function index()
    {
        $bs = new BalanceService();
        $userList = $bs->getOverview();
        $korisnik_overview = '';
        require_once __DIR__ . '/../view/overview_index.php';

    }
};

?>