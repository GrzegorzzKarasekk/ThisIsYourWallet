<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: userMenu.php');
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
        <a href="index.php"><img src="jpg/portfelicon.jpg" class="img-fluid" alt="strona główna" /></a>
        <div class=" logotext d-inline-block"><span style="color:#384D93 ">Domowy</span>Portfel</div>
    </div>

    <nav class="navbar navbar-dark bg-nav-Wallet navbar-expand-lg">

    </nav>

    <main>
        <article class="walletspage">
            <div class="container">
                <header>
                    <h1 class="font-weight-bold text-uppercase mb-2">Witaj w Twoim domowym portfelu!</h1>
                    <ul class="mx-auto text-left">
                        <li>Czy zastanawiałeś się kiedyś na co i w jaki sposób wydajesz pieniądze?</li>
                        <li>Co generuje największe dochody, a co największe koszta? Chcesz trzymać rękę na swoim budżecie?</li>
                        <li>Chcesz trzymać rękę na swoim budżecie?</li>
                    </ul>
                    <p class="text-justify">Jeżeli na któreś z podanych pytań odpowiedziałeś:
                        <span class="font-weight-bold" style="color:#384D93;font-size:20px"><q> TAK </q></span>, zapraszamy do skorzystania z aplikacji internetowej, która pomoże Ci łatwo i w przestępny sposób wyświetlić i pomóc kontrolować Twoje zasoby finansowe.
                    </p>
                </header>
                <div class="row mb-4">
                    <div class="col-sm-6 mx-auto my-auto">
                        <div class="tile">
                            <h2 class="h3 font-weight-bold my-2 ">Posiadam już konto</h2>
                            <div class="wrapper1" onclick="window.location.href='zaloguj-sie'">
                                <i class="icon-login"></i>
                                <input type="button" id="login" value="Zaloguj się!">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mx-auto my-auto">
                        <div class="tile">
                            <h2 class="h3 font-weight-bold my-2 ">Chcę założyć konto</h2>
                            <div class="wrapper2" onclick="window.location.href='zarejestruj-sie'">
                                <i class="icon-user-plus"></i>
                                <input type="button" id="logout" value="Dołącz do nas!">

                            </div>
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
</body></html>