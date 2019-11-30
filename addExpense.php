<?php

	session_start();
	
    if(!isset($_SESSION['zalogowany']))
    {
    header('Location:index.php');
    exit();
    }
    
    $dataczas = new DateTime();
    $datadomyslna = $dataczas->format('Y-m-d');

    if (isset($_POST['kwota']))
	{
	 
        $wszystko_OK=true;
        
		$kwota = $_POST['kwota'];
        if($kwota == 0)
        {
          $wszystko_OK=false;
		  $_SESSION['e_kwota']="Kwota nie może być równa zero!";  
        }
		        
		$dzien = $_POST['dzien'];
		//pobranie daty z serwera
        $dataczas = new DateTime();
        $datadomyslna = $dataczas->format('Y-m-d');
        
        
        if($dzien > $datadomyslna)
        {
            $wszystko_OK=false;
			$_SESSION['e_date']="Data nie może być większa od dzisiejszej!";
        }
        
        $wartosc_platnosci = $_POST['platnosc'];
        switch( $wartosc_platnosci )
        {
            case 'g':
            $platnosc = "Gotówka";
            break;
   
            case 'd':
            $platnosc = "Karta debetowa";
            break;
   
            case 'k':
            $platnosc = "Karta kredytowa";
            break;                
        }
        
        $wartosc_kategorii = $_POST['kategoria'];
        
        switch( $wartosc_kategorii )
        {
            case 1:
            $kategoria = "Jedzenie";
            break;
   
            case 2:
            $kategoria = "Mieszkanie";
            break;
   
            case 3:
            $kategoria = "Transport";
            break;
                
            case 4:
            $kategoria = "Telekomunikacja";
            break;  
                
            case 5:
            $kategoria = "Opieka zdrowotna";
            break;
                
            case 6:
            $kategoria = "Ubrania";
            break;
                
            case 7:
            $kategoria = "Higiena";
            break;
                
            case 8:
            $kategoria = "Dzieci";
            break;
                
            case 9:
            $kategoria = "Rozrywka";
            break;
                
            case 10:
            $kategoria = "Wycieczka";
            break;
                
            case 11:
            $kategoria = "Szkolenia";
            break;
                
            case 12:
            $kategoria = "Książki";
            break;
                
            case 13:
            $kategoria = "Oszczędności";
            break;
                
            case 14:
            $kategoria = "Na złotą jesień, czyli emeryturę";
            break;
                
            case 15:
            $kategoria = "Spłata długów";
            break;
                
            case 16:
            $kategoria = "Darowizna";
            break;
                
            case 17:
            $kategoria = "Inne wydatki";
            break;
                
        }
                
        
        $komentarz = $_POST['komentarz'];
        
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
                $id_uzytkownika = $_SESSION['id'];
                if (!$_SESSION['id']) throw new Exception($polaczenie->error);
				if ($wszystko_OK==true)
				{
                    if ($polaczenie->query("INSERT INTO wydatki VALUES (NULL, $id_uzytkownika, '$kwota', '$dzien','$platnosc', '$kategoria', '$komentarz')"))
				    {
                    $_SESSION['dochod_Dodany']="Wydatek został dodany!";
                    }
				    else
				    {
					throw new Exception($polaczenie->error);
				    }
                }
            }
				
				$polaczenie->close();
        }
			
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
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

</head>

<body>
    <div class="col-sm-12 logo mx-auto my-1 text-center">
        <a href="menu-uzytkownika"><img src="jpg/portfelicon.jpg" class="img-fluid" alt="strona główna" /></a>
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
                <div class="dropdown-divider"></div>

                <li class="nav-item mx-4"><a href="dodaj-przychod">Dodaj przychód</a></li>

                <li role="separator" class="divider"></li>
                <div class="dropdown-divider"></div>

                <li class="nav-item mx-4"><a href="dodaj-wydatek">Dodaj wydatek</a></li>

                <li role="separator" class="divider"></li>
                <div class="dropdown-divider"></div>

                <li class="nav-item mx-4"><a href="przegladaj-bilans">Przeglądaj bilans</a></li>

                <li role="separator" class="divider"></li>
                <div class="dropdown-divider"></div>

                <li class="nav-item mx-4"><a href="zmien-ustawienia">Ustawienia</a></li>

                <li role="separator" class="divider"></li>
                <div class="dropdown-divider"></div>

                <li class="nav-item mx-4"><a href="zarzadzaj-swoim-budzetem">Wyloguj</a></li>

                <li role="separator" class="divider"></li>

            </ul>

        </div>

    </nav>

    <main>
       <!-- Botstrap o poinformowaniu dodania dochodu -->
        <div class="modal" tabindex="-1" id="infoModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p style="color:black; font-size:15px; text-align: center;"><?php echo $_SESSION['dochod_Dodany'] ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='dodaj-wyatek'">Dodaj nowy wydatek </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='menu-uzytkownika'">Wróć do menu użytkownika</button>
                    </div>
                </div>
            </div>
        </div>
       
        <article class="walletspage">
            <div class="container">
                <header>
                    <h1 class="font-weight-bold text-uppercase mb-2">Dodaj nowy wydatek</h1>
                </header>
                <div class="quotation text-justify mb-4" style="font-size:20px">
                    <q>Zasada nr 1 – nigdy nie trać pieniędzy. Zasada nr 2. – nigdy nie zapominaj o zasadzie nr 1.</q><span class=" d-inline-block font-weight-bold text-right blockquote-footer" style="font-size:20px">Warren Buffett</span>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-12 mx-auto my-auto">
                        <div class="tile col-12 mx-auto my-auto">
                            <h2 class="h3 font-weight-bold my-3 text-uppercase">Wprowadź dane:</h2>

                            <form method="post">
                                <div class="wrapperForm col-12 col-md-6 mx-auto my-3 mb-2">
                                    <label for="income"> Kwota:</label> <label><input type="number" name="kwota" placeholder="Podaj kwotę wydatku" step="0.01" min="0.00" required></label>
                                </div>
                                <?php
                                    if(isset($_SESSION['e_kwota']))
                                    {
                                       echo'<span style="color:red; font-size:75%;"> '.$_SESSION['e_kwota'].'</span>';
                                       unset($_SESSION['e_kwota']);
                                    }
                                ?>
                                <div class="wrapperForm col-12 col-md-6 mx-auto my-3 mb-2">
                                    <label for="date"> Data:</label> <label><input type="date" id="datePicker" name="dzien" value="<?php echo $datadomyslna ?>" min="2000-01-01" required></label>
                                </div>
                                <?php
                                    if(isset($_SESSION['e_date']))
                                    {
                                       echo'<span style="color:red; font-size:75%;"> '.$_SESSION['e_date'].'</span>';
                                       unset($_SESSION['e_date']);
                                    }
                                ?>
                                <div class="wrapperForm col-12 col-md-6 mx-auto my-3 mb-2">
                                    <fieldset>
                                        <legend> Sposób płatności: </legend>
                                        <div><label><input type="radio" value="g" name="platnosc" checked>Gotówka</label></div>
                                        <div><label><input type="radio" value="d" name="platnosc">Karta debetowa</label></div>
                                        <div><label><input type="radio" value="k" name="platnosc">Karta kredytowa</label></div>

                                    </fieldset>
                                </div>

                                <div class="wrapperForm col-12 col-md-6 mx-auto my-3 mb-2">

                                    <lebel for="kategoria"> Kategoria transakcji:</lebel>
                                    <br />
                                    <select id="kategoria" name="kategoria" style="width:100%;">

                                        <option value="1" selected>Jedzenie</option>
                                        <option value="2">Mieszkanie</option>
                                        <option value="3">Transport</option>
                                        <option value="4">Telekomunikacja</option>
                                        <option value="5">Opieka zdrowotna</option>
                                        <option value="6">Ubrania</option>
                                        <option value="7">Higiena</option>
                                        <option value="8">Dzieci</option>
                                        <option value="9">Rozrywka</option>
                                        <option value="10">Wycieczka</option>
                                        <option value="11">Szkolenia</option>
                                        <option value="12">Książki</option>
                                        <option value="13">Oszczędności</option>
                                        <option value="14">Na złotą jesień, czyli emeryturę</option>
                                        <option value="15">Spłata długów</option>
                                        <option value="16">Darowizna</option>
                                        <option value="17">Inne wydatki</option>
                                    </select>
                                </div>

                                <div class="wrapperForm col-12 col-md-6 mx-auto my-3 mb-2">
                                    <label for="komentarz" class="relative"> Komentarz (opcjonalnie): </label>
                                    <br />
                                    <textarea name="komentarz" id="komentarz" rows="4" cols="20" maxlength="320" minlength="5"></textarea>
                                </div>


                                <label class="wrapperAccept col-12 col-md-5 mx-2  my-3 mb-2 d-inline-block"><i class="icon-calendar-minus-o"></i><input type="submit" class="dodaj" value="Dodaj"></label>

                                <div class="wrapperCancel col-12 col-md-5 mx-2 my-3 mb-2 d-inline-block" onclick="window.location.href='menu-uzytkownika'">
                                    <i class="icon-calendar-times-o"></i>
                                    <input type="button" class="anuluj" value="Anuluj">
                                </div>
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
     <?php
          if(isset($_SESSION['dochod_Dodany']))
            {
              //potwierdzenie dodania dochodu 
              echo '<script>
                $(document).ready(function()
                {
                    $("#infoModal").modal();
                });
              </script>';
            }
    ?>
    <?php
     //Usuwanie zmiennych pamiętających wartości wpisane do formularza
    if(isset($_SESSION['dochod_Dodany'])) unset($_SESSION['dochod_Dodany']);
    if(isset($kwota)) unset($kwota);
    if(isset($dzien)) unset($dzien);
    if(isset($platnosc)) unset($platnosc);
    if(isset($kategoria)) unset($kategoria);
    if(isset($komentarz)) unset($komentarz);        
    ?>
</body>
</html>
