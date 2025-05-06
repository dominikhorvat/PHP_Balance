<?php require_once __DIR__ . '/_header.php';?>

<br>

<form method="post" action="balance.php?rt=newexpense/ubaci"> <!-- pozvat ce se funkcija ubaci iz newexpenseController-a-->
    <table>
        <tr>
            <td>
            Description
            </td>
            <td>
                <input type="text" id="opis" name="description" required>
            </td>
        </tr>
    </table>

<br>
<hr>
<br>

    <table>
        <tr>
            <td>
                Cost in &#8364;
            </td>
            <td>
                <input type="number" id="opis" name="cost" required>
            </td>
        </tr>
    </table>

<br>
<hr>
<br>
    
    <table>
        <tr>
            <td>
                For
            </td>
            <td>
            <ul>
            <?php
            foreach($userList as $user)
            {
                echo '<li>' . '<input type="checkbox" name="options[]" value="'.$user->username.'">' . $user->username . '</li>'; 
            }
            ?>
            </ul> 
            </td>
        </tr>
    </table>
<br>

<button type="submit" name="gumb">Add new expense!</button>

</form>
<br>

<?php echo $poruka; ?>
<?php require_once __DIR__ . '/_footer.php'; ?>