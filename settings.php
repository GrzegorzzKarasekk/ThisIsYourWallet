<?php
session_start();//inicjalizacja sesji

if(!isset($_SESSION['zalogowany']))
{
    header('Location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
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

</head>

<body>
    <div class="col-sm-12 logo mx-auto my-1 text-center">
        <a href="zarzadzaj-swoim-budzetem"><img src="jpg/portfelicon.jpg" class="img-fluid" alt="strona główna" /></a>
        <div class=" logotext d-inline-block"><span style="color:#384D93 ">Domowy</span>Portfel</div>
    </div>

    <nav class="navbar navbar-dark bg-nav-Wallet navbar-expand-lg">

        <button class="navbar-toggler order-first" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainmenu">

            <ul class="navbar-nav mx-auto">
                <li role="separator" class="divider"></li>

                <li class="nav-item mx-4"><a href="menu-uzytkownika">Menu uzytkownika</a></li>

                <li role="separator" class="divider"></li>
                

                <li class="nav-item mx-4"><a href="dodaj-przychod">Dodaj przychód</a></li>

                <li role="separator" class="divider"></li>
                

                <li class="nav-item mx-4"><a href="dodaj-wydatek">Dodaj wydatek</a></li>

                <li role="separator" class="divider"></li>
                

                <li class="nav-item mx-4"><a href="przegladaj-bilans">Przeglądaj bilans</a></li>

                <li role="separator" class="divider"></li>
                

                <li class="nav-item mx-4"><a href="zmien-ustawienia">Ustawienia</a></li>

                <li role="separator" class="divider"></li>
                

                <li class="nav-item mx-4"><a href="wyloguj">Wyloguj</a></li>

                <li role="separator" class="divider"></li>

            </ul>

        </div>
    </nav>

    <main>
    
 <!--////////////////////////////////////////////////////////////////////////////-->
        <!-- Modal addIncome-->
        <div class="modal" id="addIncomeModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wpisz nową kategorię przychodu: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <label><input type="text" name="nowa_kategoria_przychodu" placeholder="Nowa kategoria" required></label>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="kategoria_przychodu_add" value="Dodaj">
                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal editIncome-->
        <div class="modal" id="editIncomeModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz kategorię i zmodyfikuj jej nazwę: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <fieldset>
                                 
                               <?php
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $rezultat = $polaczenie->query("SELECT *  FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                if ($rezultat->num_rows > 0)
                                {                           
                                    while($wynik=$rezultat->fetch_assoc())
                                    {
                                        echo "<div><label><input type='radio' value=".$wynik['id']." name='kategoriaP'>".$wynik['nazwa_przychodu']."</label></div>";
                                    }
                                }
                                else
                                {
                                        echo '<span style="color:red;"> BRAK KATEGORII LUB PROBLEM Z SERWEREM!</style>';
                                }
                                $polaczenie->close();
                                ?>
                                </fieldset>   
                                <label><input type="text" name="nowa_nazwa_kategorii_przychodu" placeholder="Nowa nazwa" required></label>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="kategoria_przychodu_edit" value="Zapisz">
                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal deleteIncome-->
        <div class="modal" id="deleteIncomeModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz kategorię przychodów do usunięcia: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <fieldset>
                                 
                               <?php
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $rezultat = $polaczenie->query("SELECT *  FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                if ($rezultat->num_rows > 0)
                                {                           
                                while($wynik=$rezultat->fetch_assoc())
                                    {
                                        echo "<div><label><input type='radio' value=".$wynik['id']." name='kategoriaP'>".$wynik['nazwa_przychodu']."</label></div>";
                                    }
                                }
                                else
                                {
                                        echo '<span style="color:red;"> BRAK KATEGORII LUB PROBLEM Z SERWEREM!</style>';
                                }
                                $polaczenie->close();
                                ?>
                                </fieldset>   

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="kategoria_przychodu_delete" value="Usuń">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <?php
            require_once "connect.php";
            mysqli_report(MYSQLI_REPORT_STRICT);
                                
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
             //Ogonki
            mysqli_query($polaczenie, "SET CHARSET utf8");
            mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
            //
        
            if(isset($_POST['kategoria_przychodu_add']))
            {
                $kategoriaP = $_POST['nowa_kategoria_przychodu'];
                
                //Czy już stworzona kategoria?
                $rezultat = $polaczenie->query("SELECT * FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND nazwa_przychodu='".$kategoriaP."'");
                
                if($rezultat->num_rows > 0)
                {
                  $_SESSION['zmianaWartosci'] = "Kategoria: ".$kategoriaP." już istnieje ;)";  
                }
                
                elseif($polaczenie->query("INSERT INTO przychody_przypisane_do_uzytkownika (id, id_uzytkownika, nazwa_przychodu) VALUES (NULL,".$_SESSION['id_uzytkownika'].",'".$kategoriaP."')"))
                {
                   $_SESSION['zmianaWartosci'] = "Dodano nową kategorię przychodu: ".$kategoriaP;
                }
                else
                {
                   $_SESSION['zmianaWartosci'] = "Wystąpił problem z dodaniem nowej kategorii przychodu. Prosimy spróbuj później";                   
                }
            }
            elseif(isset($_POST['kategoria_przychodu_edit']))
            {
                
                $idKategoriiP = $_POST['kategoriaP'];
                $kategoriaNewP = $_POST['nowa_nazwa_kategorii_przychodu'];
                
                                
                $rezultat = $polaczenie->query("SELECT * FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id=".$idKategoriiP);
                $wynik = $rezultat->fetch_assoc();
                $staraNazwa =$wynik['nazwa_przychodu'];
                
                if($polaczenie->query("UPDATE przychody_przypisane_do_uzytkownika SET nazwa_przychodu ='".$kategoriaNewP."' WHERE id=".$idKategoriiP))
                {
                   $_SESSION['zmianaWartosci'] = "Zmodyfikowano nazwę kategorii przychodu:<br />".$staraNazwa." na: ".$kategoriaNewP;
                   
                }
                else
                {
                   $_SESSION['zmianaWartosci'] = "Wystąpił problem z modyfikacją kategorii przychodu. Prosimy spróbuj później";                   
                }
            }
            elseif(isset($_POST['kategoria_przychodu_delete']))
            {
                
                $idKategoriiP = $_POST['kategoriaP'];
                $rezultat = $polaczenie->query("SELECT * FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id=".$idKategoriiP);
                $wynik = $rezultat->fetch_assoc();
                $nazwaKategoriiDoUsuniecia =$wynik['nazwa_przychodu'];
                                
                if($polaczenie->query("DELETE FROM przychodu_przypisane_do_uzytkownika WHERE id=".$idKategoriiP))
                {
                   $_SESSION['zmianaWartosci'] = "Usunięto kategorię przychodu: ".$nazwaKategoriiDoUsuniecia;                   
                }
                else
                {
                   $_SESSION['zmianaWartosci'] = "Wystąpił problem z modyfikacją kategorii przychodu. Prosimy spróbuj później";                   
                }
            }
        else
        {
            ;
        }
        
        $polaczenie->close();
        ?>
                
        
<!--/////////////////////////////////////////////////////////////////////////////-->
        <!-- Modal addExpense-->
        <div class="modal" id="addExpenseModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wpisz nową kategorię wydatku: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <label><input type="text" name="nowa_kategoria_wydatku" placeholder="Nowa kategoria" required></label>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="kategoria_wydatku_add" value="Dodaj">
                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <!-- Modal editExpense-->
        <div class="modal" id="editExpenseModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz kategorię i zmodyfikuj jej nazwę: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <fieldset>
                             
                               <?php
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $rezultat = $polaczenie->query("SELECT *  FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                if ($rezultat->num_rows > 0)
                                {                           
                                while($wynik=$rezultat->fetch_assoc())
                                {
                                        echo "<div><label><input type='radio' value=".$wynik['id']." name='kategoriaW'>".$wynik['nazwa_wydatku']."</label></div>";
                                }
                                }
                                else
                                {
                                        echo '<span style="color:red;"> BRAK KATEGORII LUB PROBLEM Z SERWEREM!</style>';
                                }     
                                $polaczenie->close();
                                ?>
                                </fieldset>

                            <label><input type="text" name="nowa_nazwa_kategorii_wydatku" placeholder="Nowa nazwa" required></label>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="kategoria_wydatku_edit" value="Zapisz">
                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal deleteExpense-->
        <div class="modal" id="deleteExpenseModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz kategorię wydatków do usunięcia: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">

                            <fieldset>
                                 
                               <?php
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $rezultat = $polaczenie->query("SELECT *  FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                if ($rezultat->num_rows > 0)
                                {                           
                                while($wynik=$rezultat->fetch_assoc())
                                    {
                                        echo "<div><label><input type='radio' value=".$wynik['id']." name='kategoriaW'>".$wynik['nazwa_wydatku']."</label></div>";
                                    }
                                }
                                else
                                {
                                        echo '<span style="color:red;"> BRAK KATEGORII LUB PROBLEM Z SERWEREM!</style>';
                                }   
                                $polaczenie->close();
                                ?>
                                </fieldset>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="kategoria_wydatku_delete" value="Usuń">
                               
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <?php
            require_once "connect.php";
            mysqli_report(MYSQLI_REPORT_STRICT);
                                
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
             //Ogonki
            mysqli_query($polaczenie, "SET CHARSET utf8");
            mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
            //
        
            if(isset($_POST['kategoria_wydatku_add']))
            {
                $kategoriaW = $_POST['nowa_kategoria_wydatku'];
                
                //Czy już stworzona kategoria?
                $rezultat = $polaczenie->query("SELECT * FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND nazwa_wydatku='".$kategoriaW."'");
                
                if($rezultat->num_rows > 0)
                {
                  $_SESSION['zmianaWartosci'] = "Kategoria: ".$kategoriaW." już istnieje ;)";  
                }
                
                elseif($polaczenie->query("INSERT INTO wydatki_przypisane_do_uzytkownika (id, id_uzytkownika, nazwa_wydatku) VALUES (NULL,".$_SESSION['id_uzytkownika'].",'".$kategoriaW."')"))
                {
                   $_SESSION['zmianaWartosci'] = "Dodano nową kategorię wydatku: ".$kategoriaW;
                }
                else
                {
                   $_SESSION['zmianaWartosci'] = "Wystąpił problem z dodaniem nowej kategorii wydatku. Prosimy spróbuj później";                   
                }
            }
            elseif(isset($_POST['kategoria_wydatku_edit']))
            {
                
                $idKategoriiW = $_POST['kategoriaW'];
                $kategoriaNewW = $_POST['nowa_nazwa_kategorii_wydatku'];
                
                                
                $rezultat = $polaczenie->query("SELECT * FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id=".$idKategoriiW);
                $wynik = $rezultat->fetch_assoc();
                $staraNazwa =$wynik['nazwa_wydatku'];
                
                if($polaczenie->query("UPDATE wydatki_przypisane_do_uzytkownika SET nazwa_wydatku ='".$kategoriaNewW."' WHERE id=".$idKategoriiW))
                {
                   $_SESSION['zmianaWartosci'] = "Zmodyfikowano nazwę kategorii wydatku:<br />".$staraNazwa." na: ".$kategoriaNewW;               
                }
                else
                {
                   $_SESSION['zmianaWartosci'] = "Wystąpił problem z modyfikacją kategorii wydatku. Prosimy spróbuj później";                   
                }
            }
            elseif(isset($_POST['kategoria_wydatku_delete']))
            {
                
                $idKategoriiW = $_POST['kategoriaW'];
                $rezultat = $polaczenie->query("SELECT * FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id=".$idKategoriiW);
                $wynik = $rezultat->fetch_assoc();
                $nazwaKategoriiDoUsuniecia =$wynik['nazwa_wydatku'];
                                
                if($polaczenie->query("DELETE FROM wydatki_przypisane_do_uzytkownika WHERE id=".$idKategoriiW))
                {
                   $_SESSION['zmianaWartosci'] = "Usunięto kategorię wydatku: ".$nazwaKategoriiDoUsuniecia;                   
                }
                else
                {
                   $_SESSION['zmianaWartosci'] = "Wystąpił problem z modyfikacją kategorii wydatku. Prosimy spróbuj później";                   
                }
            }
        else
        {
            ;
        }
        
        $polaczenie->close();
        ?>               

<!--/////////////////////////////////////////////////////////////////////////////-->
        
        <!-- Modal addPay-->
        <div class="modal" id="addPayModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wpisz nowy sposób płatności: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <label><input type="text" name="nowy_sposob_platnosci" placeholder="Nowy sposób płatności" required></label>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="sposob_platnosci_add" value="Zapisz">
                                                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <!-- Modal editPay-->
        <div class="modal" id="editPayModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz sposób płatności i zmodyfikuj jego nazwę: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">

                            <fieldset>
                                 
                               <?php
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $rezultat = $polaczenie->query("SELECT *  FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                if ($rezultat->num_rows > 0)
                                {                           
                                    while($wynik=$rezultat->fetch_assoc())
                                    {
                                        echo "<div><label><input type='radio' value=".$wynik['id']." name='platnosc'>".$wynik['nazwa_sposobu_platnosci']."</label></div>";
                                    }
                                }
                                else
                                {
                                        echo '<span style="color:red;"> BRAK SPOSOBU PŁATNOŚCI LUB PROBLEM Z SERWEREM!</style>';
                                }   
                                $polaczenie->close();
                                ?>
                                </fieldset>
                                
                            <label><input type="text" name="nowa_nazwa_sposobu_platnosci" placeholder="Nowa nazwa" required></label>

                            <div class="modal-footer">
                                 <input type="submit" class="btn btn-primary" name="sposob_platnosci_edit" value="Zapisz">
                               
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <!-- Modal deletePay-->
        <div class="modal" id="deletePayModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz sposób płatności do usunięcia: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">

                            <fieldset>
                                 
                               <?php
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $rezultat = $polaczenie->query("SELECT *  FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                if ($rezultat->num_rows > 0)
                                {                           
                                    while($wynik=$rezultat->fetch_assoc())
                                    {
                                        echo "<div><label><input type='radio' value=".$wynik['id']." name='platnosc'>".$wynik['nazwa_sposobu_platnosci']."</label></div>";
                                    }
                                }
                                else
                                {
                                        echo '<span style="color:red;"> BRAK SPOSOBU PŁATNOŚCI LUB PROBLEM Z SERWEREM!</style>';
                                }       
                                $polaczenie->close();
                                ?>
                                </fieldset>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="sposob_platnosci_delete" value="Usuń">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <?php
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
         //Ogonki
        mysqli_query($polaczenie, "SET CHARSET utf8");
        mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        //

        if(isset($_POST['sposob_platnosci_add']))
        {
            $sposob_platnosci = $_POST['nowy_sposob_platnosci'];

            //Czy już stworzona kategoria?
            $rezultat = $polaczenie->query("SELECT * FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND nazwa_wydatku='".$sposob_platnosci."'");

            if($rezultat->num_rows > 0)
            {
              $_SESSION['zmianaWartosci'] = "Sposób płatności: ".$sposob_platnosci." już istnieje ;)";  
            }

            elseif($polaczenie->query("INSERT INTO sposoby_platnosci_przypisane_do_uzytkownika (id, id_uzytkownika, nazwa_sposobu_platnosci) VALUES (NULL,".$_SESSION['id_uzytkownika'].",'".$sposob_platnosci."')"))
            {
               $_SESSION['zmianaWartosci'] = "Dodano nową kategorię sposobu płatności: ".$sposob_platnosci;
            }
            else
            {
               $_SESSION['zmianaWartosci'] = "Wystąpił problem z dodaniem nowego sposobu płatności. Prosimy spróbuj później";                   
            }
        }
        elseif(isset($_POST['sposob_platnosci_edit']))
        {

            $idSposobuPlatnosci = $_POST['platnosc'];
            $sposobPlatnosciNew = $_POST['nowa_nazwa_sposobu_platnosci'];


            $rezultat = $polaczenie->query("SELECT * FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id=".$idSposobuPlatnosci);
            $wynik = $rezultat->fetch_assoc();
            $staraNazwa =$wynik['nazwa_sposobu_platnosci'];

            if($polaczenie->query("UPDATE sposoby_platnosci_przypisane_do_uzytkownika SET nazwa_sposobu_platnosci ='".$sposobPlatnosciNew."' WHERE id=".$idSposobuPlatnosci))
            {
               $_SESSION['zmianaWartosci'] = "Zmodyfikowano nazwę sposobu płatności :<br />".$staraNazwa." na: ".$sposobPlatnosciNew;               
            }
            else
            {
               $_SESSION['zmianaWartosci'] = "Wystąpił problem z modyfikacją sposobu płatności. Prosimy spróbuj później";                   
            }
        }
        elseif(isset($_POST['sposob_platnosci_delete']))
        {

            $idSposobuPlatnosci = $_POST['platnosc'];
            $rezultat = $polaczenie->query("SELECT * FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND id=".$idSposobuPlatnosci);
            $wynik = $rezultat->fetch_assoc();
            $nazwaSposobuPlatnosciDoUsuniecia =$wynik['nazwa_sposobu_platnosci'];

            if($polaczenie->query("DELETE FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id=".$idSposobuPlatnosci))
            {
               $_SESSION['zmianaWartosci'] = "Usunięto kategorię wydatku: ".$nazwaSposobuPlatnosciDoUsuniecia;                   
            }
            else
            {
               $_SESSION['zmianaWartosci'] = "Wystąpił problem z modyfikacją kategorii wydatku. Prosimy spróbuj później";                   
            }
        }
    else
    {
        ;
    }

    $polaczenie->close();
    ?>
        
<!--/////////////////////////////////////////////////////////////////////////////-->
        <?php
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
         //Ogonki
        mysqli_query($polaczenie, "SET CHARSET utf8");
        mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        
        //Dane użytkownika
        $rezultat = $polaczenie->query("SELECT * FROM uzytkownicy WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']);
            
        if($rezultat->num_rows > 0)
        {
                $idUzytkownika = $_SESSION['id_uzytkownika'];
                $wynik = $rezultat->fetch_assoc();
                
                $imieUzytkownika = $wynik['imie_uzytkownika'];
                //echo 'Imie '.$imieUzytkownika;
        }
        $polaczenie->close();
    ?>
     
    <!-- Modal editUser-->
        <div class="modal" id="editUserModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Zmień swoje dane: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="changeTheUserData.php" method="post">
                            
                            <label style="font-weight: 700;"><i class="icon-user"></i><input type="text" name="imie" value="<?php echo $imieUzytkownika; ?>" placeholder="Zmień imię" required></label>
                            <br />
                            <?php
                                if(isset($_SESSION['e_imie']))
                                {
                                    echo'<span style="color:red; font-size:75%;"> '.$_SESSION['e_imie'].'</span><br />';
                                }
                            ?>  
                            <label style="font-weight: 700;"><i class="icon-key"></i><input type="password" name="haslo1" placeholder="Zmień hasło" required></label>
                            
                            <label style="font-weight: 700;"><i class="icon-key"></i><input type="password" name="haslo2" placeholder="Powtórz hasło" required></label>
                            <br/>
                            <?php
                                if(isset($_SESSION['e_haslo']))
                                {
                                    echo'<span style="color:red; font-size:75%;"> '.$_SESSION['e_haslo'].'</span><br />';
                                }
                            ?>  
                            <div class="modal-footer">
                               <input type="submit" class="btn btn-primary" name ="edituser" value="Zapisz">

                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
 
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
<!--/////////////////////////////////////////////////////////////////////////////-->
        <!-- Modal deleteUser-->
        <div class="modal" id="deleteUserModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#9C1311;text-align: center; font-weight: bold;"><?php echo $imieUzytkownika; ?> czy na pewno chcesz usunąć swoje konto?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#deleteUserPermanently" class="btn btn-primary">Usuń
                        </button>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal deleteUserPermanently-->
        <div class="modal" id="deleteUserPermanently" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#9C1311; font-weight: bold;"><?php echo $imieUzytkownika; ?>!!!</h5>
                    </div>
                    <div class="modal-body" style="background: #9C1311; text-align:center; !important;">
                    USUNIĘCIE KONTA WIĄŻE SIĘ Z USUNIĘCIEM WSZYSTKICH TWOICH DANYCH!<br />
                    CZY JESTEŚ PEWIEN TEJ OPERACJI?
                    <form action="changeTheUserData.php" method="post">
                       <label style="font-weight: 700;">ABY USUNĄĆ KONTO WPISZ SWOJE HASŁO</label>
                        <label style="font-weight: 700;"><i class="icon-key"></i><input type="password" name="haslo1" placeholder="Wpisz hasło" required></label>
                    <div class="modal-footer">
                        <input type="submit" style="backgroundcolor: red;" class="btn btn-primary" style="color: #9C1311;" name ="deleteuser" value="USUŃ">
                    
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
<!--/////////////////////////////////////////////////////////////////////////////-->
   <!-- Botstrap o poinformowaniu edycji-->
        <div class="modal" tabindex="-1" id="infoModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="color:black; font-size:15px; text-align: center;">
                        <h5 class="modal-title"><?php echo $_SESSION['zmianaWartosci'] ?></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href='refresh.php'">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>          
<!--/////////////////////////////////////////////////////////////////////////////-->
          

           <article class="walletspage">
            <div class="container">
                <header>
                    <h1 class="font-weight-bold text-uppercase mb-2">Wybierz opcję do zmiany</h1>
                </header>

                <div class="row mb-4">
                    <div class="tileOptionsEdit col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Dodaj: </h2>
                        <div class="addOptions addOptionIncome d-inline-block" data-toggle="modal" data-target="#addIncomeModal">Kategorię Przychodu</div>
                        <div class="addOptions addOptionExpense d-inline-block" data-toggle="modal" data-target="#addExpenseModal">Kategorię Wydatku</div>
                        <div class="addOptions addOptionPay d-inline-block" data-toggle="modal" data-target="#addPayModal">Sposób Płatności</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="tileOptionsEdit col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Edytuj: </h2>
                        <div class="editOptions editOptionIncome d-inline-block" data-toggle="modal" data-target="#editIncomeModal">Kategorię Przychodów</div>
                        <div class="editOptions editOptionExpense d-inline-block" data-toggle="modal" data-target="#editExpenseModal">Kategorię Wydatków</div>
                        <div class="editOptions editOptionPay d-inline-block" data-toggle="modal" data-target="#editPayModal">Sposób Płatności</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="tileOptionsEdit col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Usuń: </h2>
                        <div class="deleteOptions deleteOptionIncome d-inline-block" data-toggle="modal" data-target="#deleteIncomeModal">Kategorię Przychodu</div>
                        <div class="deleteOptions deleteOptionExpense d-inline-block" data-toggle="modal" data-target="#deleteExpenseModal">Kategorię Wydatku</div>
                        <div class="deleteOptions deleteOptionPay d-inline-block" data-toggle="modal" data-target="#deletePayModal">Sposób Płatności</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="tileOptionsEdit col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Zmień dane użytkownika: </h2>
                        <div class="editUser my-3" data-toggle="modal" data-target="#editUserModal">Edytuj dane użytkownika</div>
                        <div class="deleteUser my-3" data-toggle="modal" data-target="#deleteUserModal">Usuń użytkownika</div>
                    </div>
                </div>
            </div>
        </article>
    </main>
    <footer>
        <div class="rectangle">2019 &copy; Domowy portfel - Wszelkie prawa zastrzeżone <i class="icon-mail-alt"></i>grzegorz.karasek.programista@gmail.com
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
</body></html>
<?php
        if(isset($_SESSION['zmianaWartosci']))
        {        
           echo "<script type='text/javascript'>
           $(document).ready(function(){
           $('#infoModal').modal('show');
           });
           </script>";          
          unset($_SESSION['zmianaWartosci']);          
        }        
        if(isset($_SESSION['e_imie']))
        {
           echo "<script type='text/javascript'>
           $(document).ready(function(){
           $('#editUserModal').modal('show');
           });
           </script>";
           unset($_SESSION['e_imie']); 
        }                     
        if(isset($_SESSION['e_haslo']))
        {
           echo "<script type='text/javascript'>
           $(document).ready(function(){
           $('#editUserModal').modal('show');
           });
           </script>";
           unset($_SESSION['e_haslo']); 
        } 
                            
?>