<?php

	session_start();
	
    if(!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }
    else
    {
        $dataczas = new DateTime();
        $datadomyslna = $dataczas->format('d-m-Y');
        $firstdayThisMonthInModal = date("Y-m-d", strtotime("first day of this month"));
        $lastdayThisMonthInModal = date("Y-m-d", strtotime("last day of this month"));
        
        $firstdayThisMonth = date("d-m-Y", strtotime("first day of this month"));
        $lastdayThisMonth = date("d-m-Y", strtotime("last day of this month"));
        
        $dat1 = date("Y-m-d", strtotime("first day of this month"));
        $dat2 = date("Y-m-d", strtotime("last day of this month"));
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
        else
        {
            
            $sql="CREATE TABLE wynik_wydatkow_uzytkownika_za_okres ( id INT(11) NOT NULL AUTO_INCREMENT , id_kategorii_wydatku INT(11) NOT NULL , nazwa_kategorii VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL , calkowita_kwota DECIMAL(10,2) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
            $polaczenie->query($sql);
            
            
            $polaczenie->query("TRUNCATE TABLE wynik_wydatkow_uzytkownika_za_okres");
            
            $polaczenie->query("ALTER TABLE wynik_wydatkow_uzytkownika_za_okres ADD PRIMARY KEY (id)");
            
            $wszystkieKategorieUzytkownika = $polaczenie->query("SELECT * FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']);
            if ($wszystkieKategorieUzytkownika->num_rows > 0)
            {
                for($i=0;$i<$wszystkieKategorieUzytkownika->num_rows;$i++)
                {
                    $wynik=$wszystkieKategorieUzytkownika->fetch_assoc();
                                    
                    $polaczenie->query("INSERT INTO wynik_wydatkow_uzytkownika_za_okres (id, id_kategorii_wydatku, nazwa_kategorii) VALUES (NULL, ".$wynik['id'].",'".$wynik['nazwa_wydatku']."')");             
                
                }
                ///////////////////Dodawanie kwot do poszczegolnych kategorii/////////
            
                $kwotyZPoszczegolnychKategoriiUzytkownika = $polaczenie->query("SELECT kwota, id_kategorii_wydatku_przypisanej_do_uzytkownika FROM wydatki WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND data_wydatku BETWEEN '".$dat1."' AND'".$dat2."'");
            
                for($i=0;$i<$kwotyZPoszczegolnychKategoriiUzytkownika->num_rows;$i++)
                {
                    $wynik = $kwotyZPoszczegolnychKategoriiUzytkownika->fetch_assoc();

                    $kwotaBiezacegoWydatku_kategorii= floatval($wynik['kwota']);

                    $pobraniecenyDanejKategorii = $polaczenie->query("SELECT * FROM wynik_wydatkow_uzytkownika_za_okres WHERE id_kategorii_wydatku=".$wynik['id_kategorii_wydatku_przypisanej_do_uzytkownika']);

                    $cenaLaczna = $pobraniecenyDanejKategorii->fetch_assoc();
                    $cenaDanejKategorii = floatval($cenaLaczna['calkowita_kwota']);
                    $cenaDoWstawienia =   $cenaDanejKategorii + $kwotaBiezacegoWydatku_kategorii;


                    $polaczenie->query("UPDATE wynik_wydatkow_uzytkownika_za_okres SET calkowita_kwota =".$cenaDoWstawienia." WHERE id_kategorii_wydatku=".$wynik['id_kategorii_wydatku_przypisanej_do_uzytkownika']);
                }
            }            
            else
            {
                throw new Exception($polaczenie->error);
            }
        }
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o sprawdzenie bilansu w innym terminie!</span>';
            //echo '<br />Informacja developerska: '.$e;
        }
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

    <?php 
    if(!isset($brakwydatkow))
    
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
            else
            {
                $odczytDanychDoWykresu = $polaczenie->query("SELECT * FROM wynik_wydatkow_uzytkownika_za_okres WHERE calkowita_kwota  > 0");
                if ($odczytDanychDoWykresu->num_rows > 0)
                {
                $poloczonyStringDoWykresu = "";
                for($i=0;$i<(($odczytDanychDoWykresu->num_rows) - 1);$i++)
                {	
                    $wynik = $odczytDanychDoWykresu->fetch_assoc();
                    $cenaKategoriiDoWykresu= $wynik['calkowita_kwota'];
                    $nazwaKategoriiDoWykresu =$wynik['nazwa_kategorii'];
                    
                    $poloczonyStringDoWykresu = $poloczonyStringDoWykresu."{ y: ".$cenaKategoriiDoWykresu.", label: '".$nazwaKategoriiDoWykresu."'}, ";
                    
                }
                $wynik = $odczytDanychDoWykresu->fetch_assoc();
                $cenaKategoriiDoWykresu= $wynik['calkowita_kwota'];
                $nazwaKategoriiDoWykresu =$wynik['nazwa_kategorii'];
                    
               $poloczonyStringDoWykresu = $poloczonyStringDoWykresu."{ y: ".$cenaKategoriiDoWykresu.", label: '".$nazwaKategoriiDoWykresu."'}";
    
                    echo'<script>
                    window.onload = function() {

                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        backgroundColor: "#F7EDED",
                        title: {
                            text: "Wydatki na dany okres"
                        },
                        data: [{
                            type: "pie",
                            startAngle: 360,
                            yValueFormatString: "##0.00\"zł\"",
                            indexLabel: "{label} {y}",
                            dataPoints: ['.$poloczonyStringDoWykresu.
                            ']
                        }]
                    });
                    chart.render();

                }
                </script>';
                }
                elseif ($odczytDanychDoWykresu->num_rows == 0)
                {
                    echo '';
                }
                else
                {
                        throw new Exception($polaczenie->error);
                }             

            }
                $polaczenie->close();
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o sprawdzenie bilansu w innym terminie!</span>';
            //echo '<br />Informacja developerska: '.$e;
        }
    ?>
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

                <li class="nav-item mx-4"><a href="menu-uzytkownika">Menu użytkownika</a></li>

                <li role="separator" class="divider"></li>


                <li class="nav-item mx-4"><a href="dodaj-przychod">Dodaj przychód</a></li>

                <li role="separator" class="divider"></li>


                <li class="nav-item mx-4"><a href="dodaj-wydatek">Dodaj wydatek</a></li>

                <li role="separator" class="divider"></li>


                <li class="nav-item mx-4"><a href="zmien-ustawienia">Ustawienia</a></li>

                <li role="separator" class="divider"></li>


                <li class="nav-item mx-4"><a href="wyloguj">Wyloguj</a></li>

                <li role="separator" class="divider"></li>

            </ul>
        </div>

        <ul class="navbar nav-item dropdown" style="list-style-type: none;">
            <li>
                <a class="nav-link dropdown-toggle" href="przegladaj-bilans" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true"><span><i class="icon-calendar"></i></span>Wybierz okres dat</a>

                <div class="dropdown-menu">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href=" przegladaj-bilans"> Bieżący miesiąc</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="poprzedni-miesiac"> Poprzedni miesiąc</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="ten-rok"> Bieżący rok</a>
                    <div class="dropdown-divider"></div>
                    <a class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#niestandardowyModal" href="datecheck.php"> Niestandardowy</a>
                    <div class="dropdown-divider"></div>
                </div>

            </li>
        </ul>
    </nav>


    <main>

        <!-- Modal unregular date-->
        <div class="modal" id="niestandardowyModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz zakres dat</h5>
                    </div>
                    <div class="modal-body">
                        <form action="datecheck.php" method="post">
                            <label for="dateF"> Od:</label> <label class="d-inline-block"><input type="date" id="dateF" name="niestandardowydzien1" min="2000-01-01" value="<?php echo $firstdayThisMonthInModal ?>" required></label>
                            <label for="dateL"> Do:</label> <label class="d-inline-block"><input type="date" id="dateL" name="niestandardowydzien2" min="2000-01-01" value="<?php echo $lastdayThisMonthInModal ?>" required></label>
                            <?php
                                if(isset($_SESSION['e_date']))
                                {
                                    echo '<div style="color: red !important; font-size: 100% !important; text-align: center !important;"> '.$_SESSION['e_date'].'</div>';
                                }
                               ?>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Akceptuj">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botstrap o poinformowaniu edycji dochodu -->
        <div class="modal" tabindex="-1" id="infoModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="color:black; font-size:15px; text-align: center;">
                        <h5 class="modal-title"><?php echo $_SESSION['dochod_Zaktualizowany'] ?></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
           
        <article class="walletspage">
            <div class="container">
                <header class="dateBalance">
                    <h1 class="font-weight-bold text-uppercase mb-2">Bilans za bieżący miesiąc</h1>
                    <div class="textIn" style="color: #384D93; font-size: 20px; font-weight: bold;">
                        <?php
                        echo "Od ".$firstdayThisMonth." do ".$lastdayThisMonth;
                    ?>
                    </div>
                </header>
                <div class="quotation text-justify mb-4" style="font-size:20px">
                    <q>Zrobić budżet to wskazać swoim pieniądzom, dokąd mają iść, zamiast się zastanawiać, gdzie się rozeszły</q><span class=" d-inline-block font-weight-bold text-right blockquote-footer" style="font-size:20px">John C. Maxwell</span>
                </div>

                <div class="row mb-4">

                    <div class="tileIncomes col-12 mb-3">
                        <h2 class="h3 font-weight-bold my-2">Przychody</h2>
                        <table class="tg">
                            <thead>
                                <tr class="firstTr">
                                    <td class="tg-baqh">#</td>
                                    <td class="tg-baqh">Data</td>
                                    <td class="tg-baqh">Kwota</td>
                                    <td class="tg-baqh">Kategoria</td>
                                    <td class="tg-baqh">Komentarz</td>
                                    <td class="tg-baqh">Edytuj</td>
                                    <td class="tg-baqh">Kasuj</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $zapytaniesql="SELECT * FROM przychody WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND data_przychodu BETWEEN '".$dat1."' AND '".$dat2."'";

                                $przychodyKwotaCalkowita = 0.00;
                                   
                                $rezultat = $polaczenie->query($zapytaniesql);   
                                if($rezultat->num_rows > 0)
                                {
                                   while($wynik = $rezultat->fetch_assoc()){
                                    
                                    $id_przychodu = $wynik['id_przychodu'];
                                        
                                    $dataPobranegoPrzychodu = new DateTime($wynik['data_przychodu']);
                                    $data_przychodu = $dataPobranegoPrzychodu->format('d-m-Y');
                                                                        
                                    $kwota = $wynik['kwota']; 
                                    $kwotaObecnegoPrzychodu = floatval($kwota);
                                    $przychodyKwotaCalkowita += $kwotaObecnegoPrzychodu; 
                                    
                                    $nazwykategorii = "SELECT * FROM przychody_przypisane_do_uzytkownika WHERE id=".$wynik['id_kategorii_przychodu_przypisanej_do_uzytkownika'];   
                                    $rezultat2 = $polaczenie->query($nazwykategorii);
                                    $wynik2 = $rezultat2->fetch_assoc();    
                                    $kategoria =  $wynik2['nazwa_przychodu']; 
                                    
                                    $komentarz = $wynik['komentarz_przychodu'];
                                ?>

                                <tr class="incomeTr">
                                    <td class="tg-baqh"><?php echo $id_przychodu; ?></td>
                                    <td class="tg-baqh"><?php echo $data_przychodu; ?></td>
                                    <td class="tg-baqh"><?php echo $kwota; ?></td>
                                    <td class="tg-baqh"><?php echo $kategoria; ?></td>
                                    <td class="tg-baqh"><?php echo $komentarz; ?></td>
                                    <td class="tg-baqh edit" data-toggle="modal" data-target="#editIncomeModal<?php echo $id_przychodu; ?>"><i class="icon-pencil"></i></td>
                                    <td class="tg-baqh delete" data-toggle="modal" data-target="#dataIncomeToTrasch<?php echo $id_przychodu; ?>"><i class="icon-trash"></i></td>

                                    <!-- Modal Income-->
                                    <div class="modal" id="editIncomeModal<?php echo $id_przychodu; ?>" tabindex="-1" role="dialog" style="color:black;">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edytuj przychód nr: <?php echo $id_przychodu; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="text-align:left !important;">
                                                    <form action="editIncomeFromBilance.php" method="post">
                                                        <input type="hidden" name="idPrzychodu" value="<?php echo $id_przychodu; ?>">
                                                        <label for="date" style="font-weight: 700;"> Data: </label><label><input type="date" id="date" name="dzien" min="2000-01-01" value="<?php echo $wynik['data_przychodu']; ?>"></label>
                                                        <br />
                                                        <?php
                                                        if(isset($_SESSION['e_date_in_MODAL_INCOME']))
                                                            {
                                                               echo'<span style="color:red; font-size:75%;"> '.$_SESSION['e_date_in_MODAL_INCOME'].'</span>';
                                                            }
                                                        ?>
                                                        <br />
                                                        <label for="income" style="font-weight: 700;"> Kwota:</label> <label><input type="number" id="income" name="kwotaPrzychodu" placeholder="Podaj kwotę przychodu" step="0.01" min="0.00" value="<?php echo $kwota; ?>"></label>

                                                        <fieldset>
                                                            <?php 
                                                                $rezultat3 = $polaczenie->query("SELECT *  FROM przychody_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                                                if ($rezultat3->num_rows > 0)
                                                                {
                                                                    $wynik3=$rezultat3->fetch_assoc();
                                                                    echo "<div><label><input type='radio' value=".$wynik3['id']." name='kategoria' checked>".$wynik3['nazwa_przychodu']."</label></div>";

                                                                    while($wynik3=$rezultat3->fetch_assoc())
                                                                    {
                                                                    echo "<div><label><input type='radio' value=".$wynik3['id']." name='kategoria'>".$wynik3['nazwa_przychodu']."</label></div>";
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                        echo "BRAK KATEGORII!";
                                                                }                                               
                                                            ?>
                                                        </fieldset>

                                                        <label for="komentarz" class="relative" style="font-weight: 700; value=" <?php echo $komentarz; ?>""> Komentarz (opcjonalnie): </label>
                                                        <br />
                                                        <textarea name="komentarz" id="komentarz" rows="4" cols="25" maxlength="100"></textarea>

                                                        <div class="modal-footer">
                                                            <input type="submit" class="btn btn-primary" value="Zapisz">

                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                   
                                    <!-- Modal delete Income-->
                                    <div class="modal" id="dataIncomeToTrasch<?php echo $id_przychodu; ?>" tabindex="-1" role="dialog" style="color:black;">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Czy na pewno usunąć dane przychodu nr <?php echo $id_przychodu; ?> ?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="deleteIncomeFromBilance.php" method="post">
                                                    <input type="hidden" name="idPrzychodu" value="<?php echo $id_przychodu; ?>">
                                                
                                                    <input type="submit" class="btn btn-primary" value="Usun">
                                                    
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                                <?php
                                    }
                                    }
                                    elseif($rezultat->num_rows == 0)
                                        {
                                        echo "BRAK PRZYCHODÓW NA TEN MIESIĄC";
                                        }
                                    else
                                       echo '<span style="color:red;">BRAK POŁĄCZENIA Z SERWEREM, PRZEPRASZAMY SPRÓBUJ PÓŹNIEJ</span>';
                                ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="tileExpenses col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Wydatki</h2>
                        <table class="tg">
                            <thead>
                                <tr class="firstTr">
                                    <td class="tg-baqh">#</td>
                                    <td class="tg-baqh">Data</td>
                                    <td class="tg-baqh">Kwota</td>
                                    <td class="tg-baqh">Sposób płatnośći</td>
                                    <td class="tg-baqh">Kategoria</td>
                                    <td class="tg-baqh">Komentarz</td>
                                    <td class="tg-baqh">Edytuj</td>
                                    <td class="tg-baqh">Kasuj</td>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                
                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                                 //Ogonki
                                    mysqli_query($polaczenie, "SET CHARSET utf8");
                                    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
                                //
                                
                                $zapytaniesql="SELECT * FROM wydatki WHERE id_uzytkownika=".$_SESSION['id_uzytkownika']." AND data_wydatku BETWEEN '".$dat1."' AND '".$dat2."' ORDER BY kwota DESC";

                                $rezultat = $polaczenie->query($zapytaniesql);   
                                if($rezultat->num_rows > 0)
                                {
                                    $wydatkiKwotaCalkowita = 0.00;
                                    while($wynik = $rezultat->fetch_assoc()){
                                    
                                    $id_wydatku = $wynik['id_wydatku'];
                                        
                                    $dataPobranegoWydatku = new DateTime($wynik['data_wydatku']);
                                    $data_wydatku = $dataPobranegoWydatku->format('d-m-Y');
                                                                        
                                    $kwota = $wynik['kwota']; 
                                    $kwotaObecnegoWydatku = floatval($kwota);
                                    $wydatkiKwotaCalkowita += $kwotaObecnegoWydatku; 
                                        
                                    $sposobyPlatnoci = "SELECT * FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id=".$wynik['id_sposobu_platnosci_przypisanego_do_uzytkownika'];   
                                    $rezultat2 = $polaczenie->query($sposobyPlatnoci);
                                    $wynik2 = $rezultat2->fetch_assoc(); 
                                    $sposobPlatnosci = $wynik2['nazwa_sposobu_platnosci'];    
                                    
                                    $nazwykategorii = "SELECT * FROM wydatki_przypisane_do_uzytkownika WHERE id=".$wynik['id_kategorii_wydatku_przypisanej_do_uzytkownika'];   
                                    $rezultat3 = $polaczenie->query($nazwykategorii);
                                    $wynik3 = $rezultat3->fetch_assoc();    
                                    $kategoria =  $wynik3['nazwa_wydatku']; 
                                    
                                    $komentarz = $wynik['komentarz_wydatku'];
                                ?>

                                    <tr class="expenseTr">
                                    <td class="tg-baqh"><?php echo $id_wydatku; ?></td>
                                    <td class="tg-baqh"><?php echo $data_wydatku; ?></td>
                                    <td class="tg-baqh"><?php echo $kwota; ?></td>
                                    <td class="tg-baqh"><?php echo $sposobPlatnosci; ?></td>
                                    <td class="tg-baqh"><?php echo $kategoria; ?></td>
                                    <td class="tg-baqh"><?php echo $komentarz; ?></td>
                                    <td class="tg-baqh edit" data-toggle="modal" data-target="#editExpenseModal<?php echo $id_wydatku; ?>"><i class="icon-pencil"></i></td>
                                    <td class="tg-baqh delete" data-toggle="modal" data-target="#dataExpenseToTrasch<?php echo $id_wydatku; ?>"><i class="icon-trash"></i></td>

                                    <!-- Modal Expense-->
                                    <div class="modal" id="editExpenseModal<?php echo $id_wydatku; ?>" tabindex="-1" role="dialog" style="color:black;">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edytuj wydatek nr: <?php echo $id_wydatku; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="text-align:left !important;">
                                                    <form action="editExpenseFromBilance.php" method="post">
                                                        <input type="hidden" name="idWydatku" value="<?php echo $id_wydatku; ?>">
                                                        <label for="dateE" style="font-weight: 700;"> Data:</label><label><input type="date" id="dateE" name="dzien" min="2000-01-01" value="<?php echo $wynik['data_wydatku']; ?>"></label>
                                                        <br />

                                                        <label for="expense" style="font-weight: 700;"> Kwota:</label> <label><input type="number" id="expense" name="kwotaWydatku" placeholder="Podaj kwotę wydatku" step="0.01" min="0.00" value="<?php echo $kwota; ?>"></label>

                                                        <fieldset>
                                                            <?php 
                                                                $rezultat4 = $polaczenie->query("SELECT *  FROM sposoby_platnosci_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                                                if ($rezultat4->num_rows > 0)
                                                                {
                                                                    $wynik4=$rezultat4->fetch_assoc();
                                                                    echo "<div><label><input type='radio' value=".$wynik4['id']." name='platnosc' checked>".$wynik4['nazwa_sposobu_platnosci']."</label></div>";

                                                                    while($wynik4=$rezultat4->fetch_assoc())
                                                                    {
                                                                    echo "<div><label><input type='radio' value=".$wynik4['id']." name='platnosc'>".$wynik4['nazwa_sposobu_platnosci']."</label></div>";
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                        echo "BRAK SPOSOBU PŁATNOŚCI!";
                                                                }                                               
                                                            ?>
                                                        </fieldset>

                                                        <label for="kategoria" style="font-weight: 700;"> Kategoria transakcji:</label>
                                                        <br />
                                                        <select id="kategoria" name="kategoria" style="width:100%;">
                                                         <?php 
                                                            $rezultat5 = $polaczenie->query("SELECT * FROM wydatki_przypisane_do_uzytkownika WHERE id_uzytkownika =".$_SESSION['id_uzytkownika']);
                                                            if ($rezultat5->num_rows > 0)
                                                            {
                                                                $wynik5=$rezultat5->fetch_assoc();
                                                                echo"<option value=".$wynik5['id']." selected>".$wynik5['nazwa_wydatku']."</option>";

                                                                for($i=2; $i <= $rezultat5->num_rows; $i++)
                                                                {
                                                                    $wynik5=$rezultat5->fetch_assoc();
                                                                    echo"<option value=".$wynik5['id'].">".$wynik5['nazwa_wydatku']."</option>";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "BRAK KATEGORII!";
                                                            }    
                                                        ?>
                                                        </select>

                                                        <label for="komentarzE" class="relative" style="font-weight: 700;"> Komentarz (opcjonalnie): </label>
                                                        <br />
                                                        <textarea name="komentarz" id="komentarzE" rows="4" cols="25" maxlength="100"></textarea>

                                                        <div class="modal-footer">
                                                            <input type="submit" class="btn btn-primary" value="Zapisz">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal delete Expense-->
                                    <div class="modal" id="dataExpenseToTrasch<?php echo $id_wydatku; ?>" tabindex="-1" role="dialog" style="color:black;">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Czy na pewno usunąć dane wydatku nr <?php echo $id_przychodu; ?> ?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="deleteExpenseFromBilance.php" method="post">
                                                    <input type="hidden" name="idWydatku" value="<?php echo $id_wydatku; ?>">
                                                
                                                    <input type="submit" class="btn btn-primary" value="Usun">
                                                    
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                                <?php
                                    }
                                    }
                                    elseif($rezultat->num_rows == 0)
                                        {
                                        $brakwydatkow = 'Brak wydatkow';
                                        echo "BRAK WYDATKÓW NA TEN MIESIĄC";
                                        }
                                    else
                                       echo '<span style="color:red;">BRAK POŁĄCZENIA Z SERWEREM, PRZEPRASZAMY SPRÓBUJ PÓŹNIEJ</span>';
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
                <?php 
                if(isset($brakwydatkow))
                {
                    $kwotaCalkowitaNaDanyOkres = 0;
                }
                else
                {
                    $kwotaCalkowitaNaDanyOkres = $przychodyKwotaCalkowita - $wydatkiKwotaCalkowita;
                }
                ?>
                <div class="row mb-4">
                    <div class="col-sm-12 mx-auto my-auto" style="padding: 0;">
                        <div class="tile mb-3">
                            <h2 class="h3 font-weight-bold my-3 mx-auto ">Bilans na dany okres: <?php echo $kwotaCalkowitaNaDanyOkres.' zł'; ?></h2>
                            <?php 
                                if($kwotaCalkowitaNaDanyOkres > 0)
                                    echo '<div class="text-uppercase" style="font-weight: 700; color:greenyellow;"> Gratulacje. Świetnie zarządzasz finansami!</div>';                                
                                
                                elseif($kwotaCalkowitaNaDanyOkres == 0)
                                    echo '<div class="text-uppercase" style="font-weight: 700; color:white;"> Jest dobrze, choć może być lepiej :)</div>';                                
                                
                                else
                                    echo '<div class="text-uppercase" style="font-weight: 700; color:firebrick;"> Uważaj, wpadasz w długi!</div>';                                
                            ?>                            
                        </div>
                    </div>
                </div>
                <?php
                if(!isset($brakwydatkow))
                {
                echo'<div class="row mb-4">
                    <div class="col-12 mx-auto my-auto">
                        <div id="chartContainer" class="chartStyle" style="height: 370px; width: 100%; padding: 0;"></div>
                        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                    </div>
                </div>';
                }
                ?>
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
</body>

</html>
<?php
        if(isset($_SESSION['e_date']))
        {        
           echo "<script type='text/javascript'>
           $(document).ready(function(){
           $('#niestandardowyModal').modal('show');
           });
           </script>";
           unset($_SESSION['e_date']);
             
        }

        if(isset($_SESSION['e_date_in_MODAL_INCOME']))
        {        
           echo "<script type='text/javascript'>
           $(document).ready(function(){
           $('#editIncomeModal".(string)$_SESSION['e_id']."').modal('show');
           });
           </script>";
           unset($_SESSION['e_id']);
           unset($_SESSION['e_date_in_MODAL_INCOME']);   
        }
        
       if(isset($_SESSION['e_date_in_MODAL_EXPENSE']))
        {        
           echo "<script type='text/javascript'>
           $(document).ready(function(){
           $('#editExpenseModal".(string)$_SESSION['e_id']."').modal('show');
           });
           </script>";
           unset($_SESSION['e_id']);
           unset($_SESSION['e_date_in_MODAL_EXPENSE']);   
        }

        if(isset($_SESSION['dochod_Zaktualizowany']))
        {        
           echo "<script type='text/javascript'>
           $(document).ready(function(){
           $('#infoModal').modal('show');
           });
           </script>";
           unset($_SESSION['dochod_Zaktualizowany']);
        }
?>