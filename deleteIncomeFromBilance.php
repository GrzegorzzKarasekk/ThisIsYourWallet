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
        
        $idPrzychodu = $_POST['idPrzychodu'];
            
        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
                
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		//Ogonki
        mysqli_query($polaczenie, "SET CHARSET utf8");
        mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        // 
        
        if($polaczenie->query("DELETE FROM przychody WHERE id_przychodu=".$idPrzychodu))
        {
            $_SESSION['dochod_Zaktualizowany'] = "Przychód został usunięty!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit(); 
            
        }
        else
        {
            $_SESSION['dochod_Zaktualizowany'] = "Coś poszło nie tak :( Rekord  nie został usunięty!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit(); 
        }
        $polaczenie->close();
    }    
?>