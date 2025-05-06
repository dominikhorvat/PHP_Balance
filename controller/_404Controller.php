<?php

require_once __DIR__ . '/../model/balanceservice.class.php';

class _404Controller
{
    public function index()
    {
        $korisnik_overview = '';
        require_once __DIR__ . '/../view/404_index.php';
    }
};

?>