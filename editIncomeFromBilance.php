<?php
session_start();
	
    if(!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }
    
    $dataczas = new DateTime();
    $datadomyslna = $dataczas->format('Y-m-d');
    
    if(isset($_POST['idPrzychodu']))
    {
        
        $idPrzychodu =$_POST['idPrzychodu'];
        $wszystko_OK=true;
        
        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
                
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		//Ogonki
        mysqli_query($polaczenie, "SET CHARSET utf8");
        mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        // 
        
        $daneWybranegoPrzychodu = $polaczenie->query("SELECT * FROM przychody WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id_przychodu=".$idPrzychodu);
        
        $ile_rekordow= $daneWybranegoPrzychodu->num_rows;
        if($ile_rekordow == 1)
        $wynikDanePrzychodu = $daneWybranegoPrzychodu->fetch_assoc(); 

        $dzien = $_POST['dzien'];
        if($dzien > $datadomyslna)
        {
            $wszystko_OK=false;
            $_SESSION['e_date_in_MODAL_INCOME']="Data nie może być większa od dzisiejszej!";
            $_SESSION['e_id']=$idPrzychodu;
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
        }
        
        $kwotaPobrana = $_POST['kwotaPrzychodu'];
        $kwotaPrzychodu =floatval($kwotaPobrana);
            
        $idKategoriiUzytkownika =floatval($_POST['kategoria']);
        
        $komentarz = $_POST['komentarz'];
        //if(empty($komentarz))
        //    $komentarz = $wynikDanePrzychodu['komentarz_przychodu'];
//        
//        echo $_SESSION['id_uzytkownika']."<br />";
//        echo $_POST['idPrzychodu']."<br />";
//        echo $dzien."<br />";
//        echo $komentarz."<br />";
//        echo $kwotaPrzychodu."<br />";
        
        $id_uzytkownika = $_SESSION['id_uzytkownika'];
       	if ($wszystko_OK==true)
        {
            if($polaczenie->query("UPDATE przychody SET id_kategorii_przychodu_przypisanej_do_uzytkownika=".$idKategoriiUzytkownika.",data_przychodu='".$dzien."',kwota=".$kwotaPrzychodu.",komentarz_przychodu='".$komentarz."' WHERE id_przychodu=".$idPrzychodu))
            {
            $_SESSION['dochod_Zaktualizowany'] = "Przychód został zauktualizowany!";
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