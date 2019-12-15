<?php
session_start();
	
    if(!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try 
{
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    //Ogonki
    mysqli_query($polaczenie, "SET CHARSET utf8");
    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    //
    if ($polaczenie->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    elseif(isset($_POST['edituser']))
    {
        $wszystko_OK=true;

        $imie = $_POST['imie'];
        
        //zmiana pierwszej na duża literę Z konwersją polskich znaków
        $imie=mb_convert_case($imie,MB_CASE_TITLE,"UTF-8");
        
		//Sprawdzenie długości imienia
		if ((strlen($imie)<3) || (strlen($imie)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Imię musi posiadać od 3 do 20 znaków!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
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
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
        }
        
        

        //Sprawdź poprawność hasła
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if ((strlen($haslo1)< 6) || (strlen($haslo1) > 20))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Hasło musi posiadać od 6 do 20 znaków!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
        }

        if ($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Podane hasła nie są identyczne!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
        }	

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        if ($wszystko_OK==true)
        {       
            echo $imie.'<br ?>';
            echo $haslo_hash.'<br ?>';

                if ($polaczenie->query("UPDATE uzytkownicy SET imie_uzytkownika='".$imie."', haslo='".$haslo_hash."'"))
                {
                    echo $imie.'<br ?>';
                    echo $haslo_hash.'<br ?>';
                    $_SESSION['zmianaWartosci'] = $imie." zmieniono Twoje dane :) ";
                    header('Location:'.$_SERVER['HTTP_REFERER']);
                    exit();
                }
                else
                {
                    $_SESSION['zmianaWartosci'] = " Nie można zmienić danych. Prosimy spróbuj później ";
                    header('Location:'.$_SERVER['HTTP_REFERER']);
                    exit();
                }

        }
        else
        {
                    $_SESSION['zmianaWartosci'] = " Nie można zmienić danych. Prosimy spróbuj później ";
                    header('Location:'.$_SERVER['HTTP_REFERER']);
                    exit();
        }
   }
   elseif(isset($_POST['deleteuser']))
   {
        $wszystko_OK=true;
        if ($polaczenie->query("DELETE FROM przychody WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']))
        {
            if ($polaczenie->query("DELETE FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']))
            {
                if ($polaczenie->query("DELETE FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']))
                {
                    if ($polaczenie->query("DELETE FROM wydatki WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']))
                    {
                        if ($polaczenie->query("DELETE FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']))
                        {
                            if ($polaczenie->query("DELETE FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']))
                            {
                                if ($polaczenie->query("DELETE FROM uzytkownicy WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']))
                                {
                                    header('Location:.logout.php');
                                    exit();
                                }
                                else
                                {
                                    $_SESSION['zmianaWartosci'] = " Nie można usunąć danych. Porosimy spróbuj później ";
                                    header('Location:'.$_SERVER['HTTP_REFERER']);
                                    exit();                                    
                                }                    
                            }  
                            else
                            {
                                $_SESSION['zmianaWartosci'] = " Nie można usunąć danych. Porosimy spróbuj później ";
                                header('Location:'.$_SERVER['HTTP_REFERER']);
                                exit();
                            }                    
                        }
                        else
                        {
                                    $_SESSION['zmianaWartosci'] = " Nie można usunąć danych. Porosimy spróbuj później ";
                                    header('Location:'.$_SERVER['HTTP_REFERER']);
                                    exit();                                    
                        }
                    }  
                    else
                    {
                        $_SESSION['zmianaWartosci'] = " Nie można usunąć danych. Porosimy spróbuj później ";
                        header('Location:'.$_SERVER['HTTP_REFERER']);
                        exit();

                    }                    
                }
                else
                {
                    $_SESSION['zmianaWartosci'] = " Nie można usunąć danych. Porosimy spróbuj później ";
                    header('Location:'.$_SERVER['HTTP_REFERER']);
                    exit();

                }                
            }
            else
            {
                $_SESSION['zmianaWartosci'] = " Nie można usunąć danych. Porosimy spróbuj później ";
                header('Location:'.$_SERVER['HTTP_REFERER']);
                exit();

            }
        }
        else
        {
                    $_SESSION['zmianaWartosci'] = " Nie można usunąć danych. Porosimy spróbuj później ";
                    header('Location:'.$_SERVER['HTTP_REFERER']);
                    exit();
        }
   }
    else
    {
                throw new Exception($polaczenie->error);
    }

    $polaczenie->close();
}
catch(Exception $e)
{
    echo '<span style="color:red;">Błąd serwera! Nie można zmienić danych. Prosimy spróbuj później!</span>';
    //echo '<br />Informacja developerska: '.$e;
}

?>