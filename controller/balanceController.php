<?php

class BalanceController
{
    public function index()
    {
        // Samo preusmjeri na users podstranicu.
        header('Location: balance.php?rt=overview');
    }

}

