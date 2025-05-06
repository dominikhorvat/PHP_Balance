<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/expense.class.php';

class BalanceService
{
    function getAllUsers()
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, username, password_hash, total_paid, total_debt, email, registration_sequence, has_registered FROM dz2_users');
            $st->execute();
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }

        $arr = array();
        while ($row = $st->fetch())
        {
            $arr[] = new User($row['id'], $row['username'], $row['password_hash'], $row['total_paid'], $row['total_debt'], $row['email'], $row['registration_sequence'], $row['has_registered']);
        }
        return $arr;
    }

    function getAllExpenses()
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare( 'SELECT id, id_user, cost, description, date FROM dz2_expenses');
            $st->execute();
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }

        $allexp = array();
        while ($row = $st->fetch())
        {
            $allexp[] = new Expense($row['id'], $row['id_user'], $row['cost'], $row['description'], $row['date']);
        }
        return $allexp;
    }

    function getUsersExpenses()
    {
        try
        {
            $db = DB::getConnection();


        $st = $db->prepare('SELECT dz2_users.username, dz2_expenses.description, dz2_expenses.cost 
                            FROM dz2_users 
                            INNER JOIN dz2_expenses ON dz2_users.id = dz2_expenses.id_user
                            ORDER BY dz2_expenses.date DESC');
        
        // Izvršavanje upita
        $st->execute();
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }
        // Prikupljanje rezultata upita
        $exp = array();
        while($row = $st->fetch(PDO::FETCH_ASSOC))
        {
            $exp[] = array(
                'username' => $row['username'],
                'description' => $row['description'],
                'cost' => $row['cost']
            );
        }
        
        
        return $exp;
    }

    function getOverview()
    {
        //funkcija koja ce nam dati za overview kada dodjemo odmah na pocetnu, koliko su u plusu/minusu 
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT id,username, 
                                total_paid - total_debt AS total_payment
                                FROM dz2_users');
            $st->execute();
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }

        $overall = array();
        while($row = $st->fetch(PDO::FETCH_ASSOC))
        {
            $overall[] = array(
                'id_user' => $row['id'],
                'username' => $row['username'],
                'total_payment' => $row['total_payment']
            );
        }
        
        return $overall;
    }

    //_____________________________________________________________________________________________________
    //sljede funkcije koje se izvrsavanju kada se klikne na nekog korisnika
    //ONO ZA OVERVIEW(PERO) kako je nacrtano u pdfu od zadace
    function getUserTotal($id)
{
    try
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT total_paid - total_debt AS total
                            FROM dz2_users WHERE id=:id');
        $st->execute([':id' => $id]);
    }
    catch(PDOException $e) { exit('PDO error ' . $e->getMessage());}

    $row = $st->fetch();
    return $row['total'];
}

    function getUserExpenses($id)
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT description, cost FROM dz2_expenses WHERE id_user=:id');
            $st->execute([':id' => $id]);
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }
        $expus = array();
        while($row = $st->fetch(PDO::FETCH_ASSOC))
        {
            $expus[] = array(
                'description' => $row['description'],
                'cost' => $row['cost']
            );
        }
        return $expus;

    }

    function getUserParts($id)
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT dz2_expenses.description as description, dz2_parts.cost as cost
                                FROM dz2_expenses
                                JOIN dz2_parts ON dz2_expenses.id = dz2_parts.id_expense
                                WHERE dz2_parts.id_user=:id');
            $st->execute([':id' => $id]);
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }

        $partus = array();
        while($row = $st->fetch(PDO::FETCH_ASSOC))
        {
            $partus[] = array(
                'description' => $row['description'],
                'cost' => $row['cost']
            );
        }
        return $partus;
    }

    function getUserUsername($id)
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT username
                                FROM dz2_users WHERE id=:id');
            $st->execute([':id' => $id]);
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage());}
    
        $row = $st->fetch();
        return $row['username'];
    }

 //_____________________________________________________________________________________________________

    function getIdFromUser($userovnick)
{
    try
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT id FROM dz2_users WHERE username=:userovnick');
        $st->execute(array(':userovnick' => $userovnick)); 
        
        // Provjera rezultata
        $row = $st->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            throw new Exception("Korisnik s imenom '$userovnick' ne postoji.");
        }
        
        return $row['id'];
    }
    catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }
    catch(Exception $e) { exit('Error: ' . $e->getMessage()); }
}

    function getLastIdExpenses()
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT id FROM dz2_expenses ORDER BY id DESC LIMIT 1');
            $st->execute();
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }
        $row = $st->fetch(PDO::FETCH_ASSOC);
        $zadnjiid = $row['id'];
        return $zadnjiid;
    }

    function ubaciUExpenses($id_user, $cost, $opis)
    {
        //ubacujemo u tablicu dz2_expenses
        try
        {
            $db = DB::getConnection();
            //prvo pripremi insert naredbu.
            $st = $db->prepare('INSERT INTO dz2_expenses (id_user, cost, description, date) VALUES (:id_user, :cost, :description, :date)'); //izostavimo id kako bi se on sam inkrementiro :)
            //kako dobiti trenutni datum
            $currentDateTime = date('Y-m-d H:i:s');
            //ovo bi sad trebo dodat u dz2_expense
            $st->execute(array('id_user' => $id_user, 'cost' => $cost, 'description' => $opis, 'date' => $currentDateTime));   
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }
        return;
    }

    function ubaciUParts($zadnji_id,$id_odg_korisnika,$cost_part)
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('INSERT INTO dz2_parts (id_expense, id_user, cost) VALUES (:id_expense, :id_user, :cost)'); //izostavimo id kako bi se on sam inkrementiro :)
            $st->execute(array('id_expense' => $zadnji_id, 'id_user' => $id_odg_korisnika, 'cost' => $cost_part ));
        }
        catch(PDOException $e) { exit('PDO error ' . $e->getMessage()); }
        return;
    }

    function azurirajTotalPaid($povecaj, $id_korisnik)
    {
        try
        {
            $db = DB::getConnection();
            // Pripremite SQL upit koristeći parametre
            $st = $db->prepare('UPDATE dz2_users SET total_paid = total_paid + :povecaj WHERE id=:id_korisnik');
            // Izvršite upit sa zadanim parametrima
            $st->execute(array(':povecaj' => $povecaj, ':id_korisnik' => $id_korisnik));
        }
        catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
        return;
    }

    function azurirajTotalDebt($cost_part, $id_korisnik)
    {

        try
        {
            $db = DB::getConnection();
                $st = $db->prepare('UPDATE dz2_users SET total_debt = total_debt + :cost_part WHERE id=:id_korisnik'); //izostavimo id kako bi se on sam inkrementiro :)
                $st->execute(array(':cost_part' => $cost_part, ':id_korisnik' => $id_korisnik));
            
        }
        catch(PDOException $e) {
            exit('PDO error ' . $e->getMessage());
        }
        return;
    }

    //----- funkcija za settle up -----

    function settleDebts() {
        //spajamo se na bazu
        try 
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT id, username, total_paid, total_debt FROM dz2_users');
            $st->execute();
        } catch(PDOException $e) { exit('PDO error ' . $e->getMessage());}
    
        //dohvacamo korisnikove podatke
        $users = $st->fetchAll(PDO::FETCH_ASSOC);
    
        // radimo mapu radi lakšeg dohvaćanja korisnika
        $imena_clanova = [];
        foreach ($users as $user) 
        {
            $imena_clanova[$user['id']] = $user;
        }
    
        //racunamo balanse
        $balances = [];
        foreach ($users as $user) {
            $balances[$user['id']] = $user['total_paid'] - $user['total_debt'];
        }
    
        // moramo vidjeti tko je u minusu, a tko u plusu, gledamo je li balans < ili > 0, = 0 ne gledamo
        $debtors = [];
        $creditors = [];
        foreach ($balances as $id => $balance) 
        {
            if ($balance < 0) 
            {
                $debtors[] = ['id' => $id, 'balance' => $balance];
            } elseif ($balance > 0) 
            {
                $creditors[] = ['id' => $id, 'balance' => $balance];
            }
        }
    
        // koristit cemo usort!
        usort($debtors, function($a, $b) {
            return $a['balance'] - $b['balance'];
        });
    
        usort($creditors, function($a, $b) {
            return $a['balance'] - $b['balance'];
        });
        //polje transakcija
        $transakcije = [];
    
        // iskoristit cemo dvije "for petlje" i radimo s & kako bi mogli mijenjati dug
        foreach ($debtors as &$debtor) 
        {
            foreach ($creditors as &$creditor) 
            {
                if ($debtor['balance'] == 0) 
                {
                    break;
                }
                if ($creditor['balance'] == 0) 
                {
                    continue;
                }
                $iznos = min(-$debtor['balance'], $creditor['balance']);
                $transakcije[] = [
                    'od' => $debtor['id'],
                    'za' => $creditor['id'],
                    'iznos' => $iznos];
    
                // korigiramo dug ("minus i plus")
                $debtor['balance'] += $iznos;
                $creditor['balance'] -= $iznos;
            }
        }
        //vracamo kao listu zbog samog ispisa :) 
        return [$transakcije, $imena_clanova];
    }
};

?>