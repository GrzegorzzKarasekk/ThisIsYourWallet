<?php
    
	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
        
		//Sprawdź poprawność imienia
		$imie = $_POST['imie'];
		//zmiana pierwszej na duża literę Z konwersją polskich znaków
        $imie=mb_convert_case($imie,MB_CASE_TITLE,"UTF-8");
        
		//Sprawdzenie długości imienia
		if ((strlen($imie)<3) || (strlen($imie)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Imię musi posiadać od 3 do 20 znaków!";
		}
		
        // konstrukcja wyrażenia regularnego
        // poprawność imienia oraz nazwiska
        $sprawdz = '/(*UTF8)^[A-ZŁŚŻŹ]{1}+[a-ząęółśżźćń]+$/';
        // ereg() sprawdza dopasowanie wzorca do ciągu
        // zwraca true jeżeli tekst pasuje do wyrażenia
        
        if(preg_match($sprawdz, $imie)==false) 
        {
            $wszystko_OK=false;
			$_SESSION['e_imie']="Podano błędne imię: ".$imie;
        }
        // Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<6) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 6 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//Bot or not? Oto jest pytanie!
		$sekret = "6Lc5fMQUAAAAAL9brIKUtHAl9w5tbkv2ToZydilU";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_imie'] = $imie;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownicy WHERE email='$email'");
                //Ogonki
                mysqli_query($polaczenie, "SET CHARSET utf8");
                mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                //
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					
					if ($polaczenie->query("INSERT INTO uzytkownicy(id_uzytkownika,imie_uzytkownika,email,haslo) VALUES (NULL, '$imie', '$email', '$haslo_hash')"))
					{
                        $idOStatnioTworzonegoUzytkownika = $polaczenie->insert_id;
                        //Przypisanie użytkownikowi domyślnych przychodów               
                        $polaczenie->query("INSERT INTO przychody_przypisane_do_uzytkownika (nazwa_przychodu) SELECT nazwa_kategorii_przychodu FROM przychody_kategorie_podstawowe");
                        $polaczenie->query("UPDATE przychody_przypisane_do_uzytkownika SET id_uzytkownika='$idOStatnioTworzonegoUzytkownika' WHERE id_uzytkownika = 0");

                        //Przypisanie użytkownikowi domyślnych wydatków

                        $polaczenie->query("INSERT INTO wydatki_przypisane_do_uzytkownika (nazwa_wydatku) SELECT nazwa_kategorii_wydatku FROM wydatki_kategorie_podstawowe");
                        $polaczenie->query("UPDATE wydatki_przypisane_do_uzytkownika SET id_uzytkownika='$idOStatnioTworzonegoUzytkownika' WHERE id_uzytkownika = 0");

                        //Przypisanie użytkownikowi domyślnych sposobów płatności

                        $polaczenie->query("INSERT INTO sposoby_platnosci_przypisane_do_uzytkownika (nazwa_sposobu_platnosci) SELECT nazwa_sposobu_platnosci FROM sposoby_platnosci_podstawowe");
                        $polaczenie->query("UPDATE sposoby_platnosci_przypisane_do_uzytkownika SET id_uzytkownika='$idOStatnioTworzonegoUzytkownika' WHERE id_uzytkownika = 0"); 

                        $_SESSION['udanarejestracja']=true;
						header('Location: hello.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <!--<meta charset="utf-8">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Domowy Portfel</title>
    <meta name="description" content="Opanuj umiejętność zarządzania swoim budżetem. Przejmij kontrolę nad swoim portfelem. Sprawdź na czym możesz oszczędzić!">
    <meta name="keywords" content="budżet, wydatki, zarządzanie, przychody, bilans">
    <meta name="author" content="Grzegorz Karasek">

    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/fontello.css" type="text/css" />

    <script src="https://www.google.com/recaptcha/api.js?render=_reCAPTCHA_site_key"></script>

</head>

<body>
    <div class="col-sm-12 logo mx-auto my-1 text-center">
        <a href="zarzadzaj-swoim-budzetem"><img src="jpg/portfelicon.jpg" class="img-fluid" alt="strona główna" /></a>
        <div class=" logotext d-inline-block"><span style="color:#384D93 ">Domowy</span>Portfel</div>
    </div>

    <nav class="navbar navbar-dark bg-nav-Wallet navbar-expand-lg">
    </nav>

    <main>
        <article class="walletspage">
            <div class="container">
                <header>
                    <h1 class="font-weight-bold text-uppercase mb-2">Rejsetracja</h1>
                </header>
                <div class="row mb-4">
                    <div class="col-sm-12 mx-auto my-auto">
                        <div class="tile col-12 mx-auto my-auto">
                            <h2 class="h3 font-weight-bold my-3 text-uppercase">Wprowadź swoje dane:</h2>
                            <form method="post">
                                <div class="wrapperForm col-12 col-md-6 ml-2 my-3 mb-2">
                                    <label><i class="icon-user"></i><input type="text" name="imie" placeholder="Wprowadź imię" required></label>
                                </div>
                                <?php
                                    if(isset($_SESSION['e_imie']))
                                    {
                                       echo'<div style="color: red !important; font-size: 75% !important; text-align: left !important;"> '.$_SESSION['e_imie'].'</div>';
                                       unset($_SESSION['e_imie']);
                                    }
                                ?>
                                <div class="wrapperForm col-12 col-md-6 ml-2 my-3 mb-2">
                                    <label><i class="icon-mail-alt"></i><input type="email" name="email" placeholder="Wprowadź email" required></label>

                                </div>
                                <?php
                                    if(isset($_SESSION['e_email']))
                                    {
                                       echo'<div style="color: red !important; font-size: 75% !important; text-align: left !important;">'.$_SESSION['e_email'].'</div>';
                                       unset($_SESSION['e_email']);
                                    }
                                ?>
                                <div class="wrapperForm col-12 col-md-6 ml-2 my-3 mb-2">
                                    <label><i class="icon-key"></i><input type="password" name="haslo1" placeholder="Wprowadź hasło" required></label>

                                </div>
                                <?php
                                    if(isset($_SESSION['e_haslo']))
                                    {
                                        echo'<div style="color: red !important; font-size: 75% !important; text-align: left !important;">'.$_SESSION['e_haslo'].'</div>';
                                        unset($_SESSION['e_haslo']);
                                    }
                                ?>
                                <div class="wrapperForm col-12 col-md-6 ml-2 my-3 mb-2">
                                    <label><i class="icon-key"></i><input type="password" name="haslo2" placeholder="Powtórz hasło" required></label>

                                </div>
                                <?php
                                    if(isset($_SESSION['e_haslo']))
                                    {
                                       echo'<div style="color: red !important; font-size: 75% !important; text-align: left !important;">'.$_SESSION['e_haslo'].'</div>';
                                       unset($_SESSION['e_haslo']);
                                    }
                                ?>
                                <div class="wrapperForm col-12 col-md-6 ml-2 my-3 mb-2">
                                    <div class="g-recaptcha my-2" data-sitekey="6Lc5fMQUAAAAAH5CL-lMZLub6PWRH0xUtrvBCZL_">
                                    </div>

                                </div>
                                <?php
                                    if(isset($_SESSION['e_bot']))
                                    {
                                        echo'<div style="color: red !important; font-size: 75% !important; text-align: left !important;">'.$_SESSION['e_bot'].'</div>';
                                        unset($_SESSION['e_bot']);
                                    }
                                ?>


                                <label class="wrapper2 col-12 col-md-6 mx-auto mb-4"><i class="icon-user-plus"></i><input type="submit" id="logout" value="Zarejestruj się!"></label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>
    <footer>
        <div class="rectangle">2019 &copy; Domowy portfel - Wszelkie prawa zastrzeżone <i class="icon-mail-alt"> </i>grzegorz.karasek.programista@gmail.com
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
