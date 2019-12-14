<?php
session_start();
	
    if(!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }
    
    $dataczas = new DateTime();
    $datadomyslna = $dataczas->format('Y-m-d');
    
    if(isset($_POST['idWydatku']))
    {
        
        $idWydatku =$_POST['idWydatku'];
        $wszystko_OK=true;
        
        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
                
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		//Ogonki
        mysqli_query($polaczenie, "SET CHARSET utf8");
        mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        $daneWybranegoWydatku = $polaczenie->query("SELECT * FROM wydatki WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id_wydatku=".$idWydatku);
        
        $ile_rekordow= $daneWybranegoWydatku->num_rows;
        if($ile_rekordow == 1)
        $wynikDaneWydatku = $daneWybranegoWydatku->fetch_assoc(); 

        $dzien = $_POST['dzien'];
        if($dzien > $datadomyslna)
        {
            $wszystko_OK=false;
            $_SESSION['e_date_in_MODAL_EXPENSE']="Data nie może być większa od dzisiejszej!";
            $_SESSION['e_id']=$idWydatku;
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
        }
        
        $kwotaPobrana = $_POST['kwotaWydatku'];
        $kwotaWydatku =floatval($kwotaPobrana);
        
        $idSposobuPlatnosci = floatval($_POST['platnosc']);
        $idKategoriiUzytkownika = floatval($_POST['kategoria']);
        
        $komentarz = $_POST['komentarz'];
        //if(empty($komentarz))
        //    $komentarz = $wynikDaneWydatku['komentarz_wydatku'];

        
        $id_uzytkownika = $_SESSION['id_uzytkownika'];
     	if ($wszystko_OK==true)
        {                 
            if($polaczenie->query("UPDATE wydatki SET id_kategorii_wydatku_przypisanej_do_uzytkownika=".$idKategoriiUzytkownika.",id_sposobu_platnosci_przypisanego_do_uzytkownika=".$idSposobuPlatnosci.",data_wydatku='".$dzien."',kwota=".$kwotaWydatku.",komentarz_wydatku='".$komentarz."' WHERE id_wydatku=".$idWydatku))
            {
                
//            ///////////////////Dodawanie kwot do poszczegolnych kategorii/////////
//            $polaczenie->query("TRUNCATE TABLE wynik_wydatkow_uzytkownika_za_okres");
//            $polaczenie->query("ALTER TABLE wynik_wydatkow_uzytkownika_za_okres ADD PRIMARY KEY (id)");
//                
//            $wszystkieKategorieUzytkownika = $polaczenie->query("SELECT * FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']);
//            if ($wszystkieKategorieUzytkownika->num_rows > 0)
//            {
//                //echo $_SESSION['id_uzytkownika']." ".$wszystkieKategorieUzytkownika->num_rows;
//                for($i=0;$i<$wszystkieKategorieUzytkownika->num_rows;$i++)
//                {
//                    $wynik=$wszystkieKategorieUzytkownika->fetch_assoc();
//                    //echo $wynik['id']." ".$wynik['nazwa_wydatku']."<br />";
//                    
//                    $polaczenie->query("INSERT INTO wynik_wydatkow_uzytkownika_za_okres (id, id_kategorii_wydatku, nazwa_kategorii) VALUES (NULL, ".$wynik['id'].",'".$wynik['nazwa_wydatku']."')");             
//                
//                }
//            }
//            
//            $kwotyZPoszczegolnychKategoriiUzytkownika = $polaczenie->query("SELECT kwota, id_kategorii_wydatku_przypisanej_do_uzytkownika FROM wydatki WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND data_wydatku BETWEEN '".$dat1."' AND'".$dat2."'");
//            
//            for($i=0;$i<$kwotyZPoszczegolnychKategoriiUzytkownika->num_rows;$i++)
//            {
//                 $wynik = $kwotyZPoszczegolnychKategoriiUzytkownika->fetch_assoc();
//                 
//                 $kwotaBiezacegoWydatku_kategorii= floatval($wynik['kwota']);
//                 
//                  $pobraniecenyDanejKategorii = $polaczenie->query("SELECT * FROM wynik_wydatkow_uzytkownika_za_okres WHERE id_kategorii_wydatku=".$wynik['id_kategorii_wydatku_przypisanej_do_uzytkownika']);
//                  
//                  $cenaLaczna = $pobraniecenyDanejKategorii->fetch_assoc();
//                  $cenaDanejKategorii = floatval($cenaLaczna['calkowita_kwota']);
//                  $cenaDoWstawienia =   $cenaDanejKategorii + $kwotaBiezacegoWydatku_kategorii;
//                
//                    
//                  $polaczenie->query("UPDATE wynik_wydatkow_uzytkownika_za_okres SET calkowita_kwota =".$cenaDoWstawienia." WHERE id_kategorii_wydatku=".$wynik['id_kategorii_wydatku_przypisanej_do_uzytkownika']);
//            }   

            $_SESSION['dochod_Zaktualizowany'] = "Wydatek został zaktualizowany!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit(); 
            }
            else
            {
            $_SESSION['dochod_Zaktualizowany'] = "Problem z serwerem. Rekord NIE ZOSTAŁ ZAKTUALIZOWANY!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit(); 
            }
        }
        $polaczenie->close();
    }
?>