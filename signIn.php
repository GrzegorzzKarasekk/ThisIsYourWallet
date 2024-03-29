<?php
session_start();//inicjalizacja sesji

if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))
{
    header('Location:userMenu.php');
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

    </nav>

    <main>
        <article class="walletspage">
            <div class="container">
                <header>
                    <h1 class="font-weight-bold text-uppercase mb-2">Logowanie</h1>
                </header>
                <div class="row mb-4">
                    <div class="col-sm-12 mx-auto my-auto">
                        <div class="tile col-12 mx-auto my-auto">
                            <h2 class="h3 font-weight-bold my-2 text-uppercase">Podaj swoje dane:</h2>
                            <form action="login.php" method="post">
                                <div class="wrapperForm col-12 col-md-6 ml-2 mr-2 my-3 mb-2">
                                    <label><i class="icon-mail-alt"></i><input type="email" name="email" placeholder="Podaj swój email" required></label>
                                </div>
                                <div class="wrapperForm col-12 col-md-6 ml-2 my-3 mb-2">
                                    <label><i class="icon-key"></i><input type="password" name="haslo" placeholder="Podaj swoje hasło" required></label>
                                </div>

                                <label class="wrapper1 col-12 col-md-6 mx-auto mb-5"><i class="icon-login"></i>
                                    <input type="submit" id="login" value="Zaloguj się!"></label>
                            </form>
                            <?php
	                           if(isset($_SESSION['blad']))	echo $_SESSION['blad']."<br />";
                                unset($_SESSION['blad']);    
                            ?>


                            <span class="col-sm-12 mx-auto"><i>Nie posiadasz konta? - Dołącz do nas!</i></span>
                            <div class="wrapper2 col-12 col-md-6 mx-auto mb-4" onclick="window.location.href='zarejestruj-sie'">
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
</body>

</html>
