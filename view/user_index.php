<?php require_once __DIR__ . '/_header.php';?>

<br>
<?php
//ispis svega primljenog
foreach($userParts as $part){
    echo '<table>'.
            '<tr>'.
                '<td class="overview-ime">'.$part['description'] .'</td>'.
                '<td class="expense-euro">'. '-'. $part['cost'] .' &#8364;' .'</td>'.
            '</tr>' . 
            '</table> <hr>';
}

    foreach($userExpenses as $exp){
        echo '<table>'.
                '<tr>'.
                    '<td class="overview-ime">'.$exp['description'] .'</td>'.
                    '<td class="expense-euro">'. '+'. $exp['cost'] .' &#8364;' .'</td>'.
                '</tr>' . 
                '</table> <hr>';
    }

?>


<br>
    <?php
                echo '<table>'.
                '<tr>'.
                    '<td class="overview-ime">'. '<b>'.'Total' .'<b>' .'</td>'.
                    '<td class="expense-euro">'. $userTotal .' &#8364;' .'</td>'.
                '</tr>' . 
                '</table> <hr>';
    ?>

<?php require_once __DIR__ . '/_footer.php'; ?>
