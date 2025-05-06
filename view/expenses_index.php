<?php require_once __DIR__ . '/_header.php';?>

    <br>
    
    <?php

        foreach($expenseList as $expense)
        {
            echo '<table>'.
                    '<tr>'.
                        '<td class="expense-description">'.$expense['description'] .'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="expense-ime">'. $expense['username'] .'</td>'.
                        '<td class="expense-euro">'. $expense['cost'] .' &#8364;' .'</td>'.
                    '</tr>' . 
            '</table> <hr>';
        }
    ?>

<?php require_once __DIR__ . '/_footer.php';?>