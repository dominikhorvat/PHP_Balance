<?php

function crtaj_loginForma($message='')
{
    
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance - Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <h1>Balance</h1>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="username">Korisničko ime:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Lozinka:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="gumb" class="btn" value="Ulogiraj se">
            </div>
        </form>
        <div class="form-group">
                <a href="novi.php" class="btn2"> Napravi korisnički račun </a>
            </div>
        <br>
        <?php 
			if( $message !== '' )
				echo '<p>' . $message . '</p>';
	?>
    </div>
    
</body>
</html>
<?php

}

function crtaj_registerForma($message = '')
{ 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance - Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <h1>Balance</h1>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="username">Odaberi korisničko ime:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Odaberi lozinku:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Vaša mail-adresa:</label>
                <input type="text" name="email" required>
            </div>
            <div class="form-group">
                <input type="submit" name="gumb" class="btn" value="Stvori račun!">
            </div>
        </form>
        <div class="form-group">
                <a href="balance.php" class="btn2">Vrati na stranicu za login</a>
            </div>
        <br>
        <?php 
			if( $message !== '' )
				echo '<p>' . $message . '</p>';
	?>
    </div>
    
</body>
</html>
<?php
}

function crtaj_zahvalaNaRegistraciji(){
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zahvala na registraciji</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div class="container">
        <h1>Balance</h1>
        <p>
		Registracija je uspješno provedena.<br />
		Sada se možete ulogirati na početnoj stranici.
	</p>

        <div class="form-group">
                <a href="index.php" class="btn2"> Povratak na početnu stranicu! </a>
            </div>
    </div>
    </body>
    </html>
<?php
}

function crtaj_zahvalaNaPrijavi(){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zahvala na registraciji</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div class="container">
        <h1>Balance</h1>
        <p>
        Zahvaljujemo na prijavi. Da biste dovršili registraciju, kliknite na link u mailu kojeg smo Vam poslali.
        </p>

        <div class="form-group">
                <a href="index.php" class="btn2"> Povratak na početnu stranicu! </a>
            </div>
    </div>
    </body>
    </html>
<?php
}