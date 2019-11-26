<?php

session_start();//inicjalizacja sesji

if((!isset($_POST['email'])) || (!isset($_POST['haslo'])))
{
    header('Location:signIn.php');
    exit();
}
    

require_once "connect.php";//require Wymaga pliku w kodzie, once dołączy jeżeli nie został już wcześniej.

mysqli_report(MYSQLI_REPORT_STRICT);

try
{
    $polaczenie= new mysqli($host, $db_user, $db_password, $db_name);
    
    if ($polaczenie->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    
    else
    {
    $email=$_POST['email'];
    $haslo=$_POST['haslo'];
    
   // echo"It works!";
    
    $email = htmlentities($email,ENT_QUOTES,'UTF-8');
        
    if($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM uzytkownicy WHERE email='%s'", mysqli_real_escape_string($polaczenie,$email))))
    
    {
        $ilu_userow= $rezultat->num_rows;
        if($ilu_userow > 0)
        {
           $wiersz = $rezultat->fetch_assoc();
            
            if(password_verify($haslo,$wiersz['haslo']))
            {
                $_SESSION['zalogowany']=true;
            
                $_SESSION['id']=$wiersz['id'];
            
                $_SESSION['imie']= $wiersz['imie'];    
                $_SESSION['email']= $wiersz['email'];   
            
                unset($_SESSION['blad']);
                $rezultat->close();
                //echo $user;
                header('Location:userMenu.php');
            }
            
            else
            {
                        
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: signIn.php');
            
            }
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
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$e;
}
?>