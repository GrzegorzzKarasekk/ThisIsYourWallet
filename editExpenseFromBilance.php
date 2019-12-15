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