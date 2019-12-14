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

    <header>

        <nav class="navbar navbar-dark bg-nav-Wallet navbar-expand-lg">

            <button class="navbar-toggler order-first" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainmenu">

                <ul class="navbar-nav mx-auto">

                    <li role="separator" class="divider"></li>
                    
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
                    
                    <li class="nav-item mx-4"><a href="wyloguj">Wyloguj się</a></li>

              
                </ul>

            </div>

        </nav>

    </header>

    <main>
        <article class="walletspage">
            <div class="container">
                <header>
                   <?php
                    echo "<h1 class='font-weight-bold text-uppercase mb-2'>Witaj ".$_SESSION['imie_uzytkownika']." :D</h1>";
                    ?>
                    <div class="quotation text-justify mb-4" style="font-size:20px">
                        <q>Pieniądzom trzeba rozkazywać, a nie służyć </q><span class=" d-inline-block font-weight-bold text-right blockquote-footer" style="font-size:20px">Seneka</span>
                    </div>
                </header>

                <div class="row mb-4">
                    <div class="col-sm-6 mx-auto my-auto" onclick="window.location.href='dodaj-przychod'">
                        <div class="tileMenu">
                            <div id="menuTile1">
                                <i class="icon-calendar-plus-o display-inline-block"></i>
                                <input type="button" class="menuButton1 display-inline-block" value="Dodaj przychód">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mx-auto my-auto" onclick="window.location.href='dodaj-wydatek'">
                        <div class="tileMenu">
                            <div id="menuTile2">
                                <i class="icon-calendar-minus-o display-inline-block"></i>
                                <input type="button" class="menuButton2" value="Dodaj wydatek">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-2">
                    <div class="col-sm-6 mx-auto my-auto" onclick="window.location.href='przegladaj-bilans'">
                        <div class="tileMenu">
                            <div id="menuTile3">
                                <i class="icon-calc display-inline-block"></i>
                                <input type="button" class="menuButton3 display-inline-block" value="Przegladaj bilans">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mb-4">
                    <div class="col-sm-6 mx-auto my-auto" onclick="window.location.href='zmien-ustawienia'">
                        <div class="tileMenu">
                            <div id="menuTile4">
                                <i class="icon-cogs display-inline-block"></i>
                                <input type="button" class="menuButton4 display-inline-block" value="Zmień ustawienia">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mx-auto my-auto" onclick="window.location.href='wyloguj'">
                        <div class="tileMenu">
                            <div id="menuTile5">
                                <i class="icon-logout display-inline-block"></i>
                                <input type="button" class="menuButton5 display-inline-block" value="Wyloguj się">
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
