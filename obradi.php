<?php

require_once __DIR__ . '/app/database/db.class.php';
require_once 'crtaj_html.php';

function procesiraj_login()
{
    // Provjeri je li korisničko ime prazno ili neispravno
    if(empty($_POST["username"]) || !preg_match('/^[a-zA-Z]{2,20}$/', $_POST["username"])) {
        crtaj_loginForma('Korisničko ime nije ispravno.');
        return;
    }

    // Provjeri je li lozinka postavljena
    if(empty($_POST["password"])) {
        crtaj_loginForma('Lozinka nije unesena.');
        return;
    }

    //iako provjera za praznost korisnickog imena i postavljenost lozinke nije potrebna zbog required na poljima za unos...

    // Provjeri korisnika u bazi
    $db = DB::getConnection();

    try {
        $st = $db->prepare('SELECT password_hash, has_registered FROM dz2_users WHERE username=:username');
        $st->execute(array('username'=>$_POST["username"]));
    } catch(PDOException $e) {
        crtaj_loginForma('Greška:'.$e->getMessage());
        return;
    }

    $row = $st->fetch();

    if($row === false) 
	{
        crtaj_loginForma('Ne postoji korisnik s tim imenom.');
        return;
    } 
	else if($row['has_registered'] === '0')
	{
		crtaj_loginForma('Korisnik s tim imenom se nije još registrirao. Provjerite e-mail.');
		exit();
	}
	else{
        // Provjeri ispravnost lozinke
        $hash = $row['password_hash'];
        if(!password_verify($_POST['password'], $hash)) {
            crtaj_loginForma('Postoji korisnik, ali lozinka nije ispravna.');
            return;
        } else {
            //Sve je OK, ulogiramo se, u $_SESSION['user'] spremljen nas korisnik $_POST['username']
            // kojeg smo dobili tokom logina :)
            $_SESSION['user'] = $_POST['username'];
            //postavljamo cookie         
            setcookie('user', $_SESSION['user'], time()+1800);
            //prelazimo na glavnu stranicu
            require_once 'balance.php';
        }
    }
}

function procesiraj_novi(){

    // Analizira $_POST iz forme za stvaranje novog korisnika

	if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) || !isset( $_POST['email'] ) )
	{
		crtaj_registerForma( 'Trebate unijeti korisničko ime, lozinku i e-mail adresu.' );
		exit();
	}

	if( !preg_match( '/^[A-Za-z]{3,20}$/', $_POST['username'] ) )
	{
		crtaj_registerForma( 'Korisničko ime treba imati između 3 i 20 slova.' );
		exit();
	}
	else if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
	{
		crtaj_registerForma( 'E-mail adresa nije ispravna.' );
		exit();
	}
	else
	{
		// Provjeri jel već postoji taj korisnik u bazi
		$db = DB::getConnection();

		try
		{
			$st = $db->prepare( 'SELECT * FROM dz2_users WHERE username=:username' );
			$st->execute( array( 'username' => $_POST['username'] ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		if( $st->rowCount() !== 0 )
		{
			// Taj user u bazi već postoji
			crtaj_registerForma( 'Korisnik s tim imenom već postoji u bazi.' );
			exit();
		}

		// Dakle sad je napokon sve ok.
		// Dodaj novog korisnika u bazu. Prvo mu generiraj random string od 10 znakova za registracijski link.
		$reg_seq = '';
		for( $i = 0; $i < 20; ++$i )
			$reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo

		try
		{
			$st = $db->prepare( 'INSERT INTO dz2_users(username, password_hash, total_paid, total_debt, email, registration_sequence, has_registered) VALUES ' .
				                '(:username, :password, 0, 0, :email, :reg_seq, 0)' );
			
			$st->execute( array( 'username' => $_POST['username'], 
								'password' => password_hash( $_POST['password'], PASSWORD_DEFAULT ), 
								'email' => $_POST['email'], 
								'reg_seq'  => $reg_seq ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		// Sad mu još pošalji mail
		$to       = $_POST['email'];
		$subject  = 'Registracijski mail';
		$message  = 'Poštovani ' . $_POST['username'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
		$message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/register.php?niz=' . $reg_seq . "\n";
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		            'X-Mailer: PHP/' . phpversion();

		$isOK = mail($to, $subject, $message, $headers);

		if( !$isOK )
			exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );

		// Zahvali mu na prijavi.
		crtaj_zahvalaNaPrijavi();
		exit();
	}
}


