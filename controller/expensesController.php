<?php

require_once __DIR__ .'/../model/balanceservice.class.php';

class ExpensesController
{
    public function index()
    {
        $bs = new BalanceService();
        $expenseList = $bs->getUsersExpenses();
        $korisnik_overview = '';
        require_once __DIR__ . '/../view/expenses_index.php';

    }
};

