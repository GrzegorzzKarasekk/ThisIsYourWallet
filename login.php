<?php

session_start();//inicjalizacja sesji

if((!isset($_POST['email'])) || (!isset($_POST['haslo'])))
{
    header('Location:zaloguj-sie');
    exit();
}
    

require_once "connect.php";//require Wymaga pliku w kodzie, once dołączy jeżeli nie został już wcześniej.

mysqli_report(MYSQLI_REPORT_STRICT);

try
{
    $polaczenie= new mysqli($host, $db_user, $db_password, $db_name);
    //Ogonki
            mysqli_query($polaczenie, "SET CHARSET utf8");
            mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    //
    if ($polaczenie->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    
    else
    {
    $email=$_POST['email'];
    $haslo=$_POST['haslo'];
    
   // echo"It works!";
        
    //echo $email.'<br />';
    //echo $haslo.'<br />';
    
    $email = htmlentities($email,ENT_QUOTES,'UTF-8');
    echo $email.'<br />';    
    
    if($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM uzytkownicy WHERE email='%s'", mysqli_real_escape_string($polaczenie,$email))))
        
    {
        $ilu_userow= $rezultat->num_rows;
        //echo $ilu_userow.'<br />';
        if($ilu_userow > 0)
        {
           $wiersz = $rezultat->fetch_assoc();
            
            if(password_verify($haslo,$wiersz['haslo']))
            {
                $_SESSION['zalogowany']=true;
            
                $_SESSION['id_uzytkownika']=$wiersz['id_uzytkownika'];
            
                $_SESSION['imie_uzytkownika']= $wiersz['imie_uzytkownika'];    
                $_SESSION['email']= $wiersz['email']; 
                
                $sql="CREATE  TABLE wynik_wydatkow_uzytkownika_za_okres ( id INT(11) NOT NULL AUTO_INCREMENT , id_kategorii_wydatku INT(11) NOT NULL , nazwa_kategorii VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL , calkowita_kwota DECIMAL(10,2) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
                $polaczenie->query($sql);
            
                unset($_SESSION['blad']);
                $rezultat->close();
                header('Location:userMenu.php');
            }            
            else
            {
                        
              $_SESSION['blad'] = '<span style="color:red">Nieprawidłowe hasło!</span>';
              header('Location:signIn.php');
            
            }
        }
        else
            {
                        
              $_SESSION['blad'] = '<span style="color:red">Brak użytkownika o podanym emailu!</span>';
              header('Location:signIn.php');
            
            }
    }
    else
        {
                        
           throw new Exception($polaczenie->error);
            
        }
        
    $polaczenie->close();

    } 
    
}

catch(Exception $e)
{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$e;
}
?>
