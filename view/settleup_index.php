<?php require_once __DIR__ . '/_header.php'; ?>

<br>

<?php
//ispis odgovarajucih podataka primljenih iz settleupController.php
foreach ($transakcije as $transakcija) 
{
    $od_korisnika = $imena_clanova[$transakcija['od']];
    $za_korisnika = $imena_clanova[$transakcija['za']];
    echo '<table>'. 
    '<tr>' . 
    '<td>' . $od_korisnika['username'] . '</td>' .
    '<td>' . 'daje' . '</td>' .
    '<td>' . $za_korisnika['username'] . '</td>' .
    '<td>' . $transakcija['iznos'] .' &#8364;' . '</td>' . '</tr>' . 
    '</table> <hr>'; 
}
?>


<?php require_once __DIR__ . '/_footer.php'; ?>