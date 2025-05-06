<?php $korisnik_overview = '';
require_once __DIR__ . '/_header.php';?>

<br>
    <?php
        foreach($userList as $user)
        {
                echo '<table>'.
                '<tr>'.
                    '<td class="overview-ime">'. '<a href="balance.php?rt=users&id_user=' . $user['id_user'] . '">' . $user['username'] .'</td>'.
                    '<td class="expense-euro">'. $user['total_payment'] .' &#8364;' .'</td>'.
                '</tr>' . 
                '</table> <hr>';
        }
    ?>

<?php require_once __DIR__ . '/_footer.php'; ?>