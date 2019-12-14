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
                

                <li class="nav-item mx-4"><a href="zarzadzaj-swoim-budzetem">Wyloguj</a></li>

                <li role="separator" class="divider"></li>

            </ul>

        </div>
    </nav>

    <main>


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
                        <form action="settings.php" method="post">
                            <label><input type="text" name="kategoria" placeholder="Nowa kategoria" required></label>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
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
                        <form action="settings.php" method="post">
                            <label><input type="text" name="kategoria" placeholder="Nowa kategoria" required></label>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
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
                        <form action="settings.php" method="post">
                            <label><input type="text" name="kategoria" placeholder="Nowy sposób płatności" required></label>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
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
                        <h5 class="modal-title">Wybierz kategorię i wpisz nową nazwę przychodu: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="settings.php" method="post">

                            <fieldset>
                                <label for="kategoria" style="font-weight: 700;"> Kategoria:</label>
                                <div><label><input type="radio" value="1" name="kategoria" checked>Wynagrodzenie</label></div>
                                <div><label><input type="radio" value="2" name="kategoria">Odsetki bankowe</label></div>
                                <div><label><input type="radio" value="3" name="kategoria">Sprzedaż na allegro</label></div>
                                <div><label><input type="radio" value="4" name="kategoria">Inne</label></div>
                            </fieldset>


                            <label><input type="text" name="edytowanaKategoria" placeholder="Nowa nazwa" required></label>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
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
                        <h5 class="modal-title">Wybierz kategorię i wpisz nową nazwę wydatków: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="settings.php" method="post">

                            <fieldset>
                                <label for="kategoria" style="font-weight: 700;"> Kategoria:</label>
                                <div><label><input type="radio" value="1" name="kategoria" checked>Jedzenie</label></div>
                                <div><label><input type="radio" value="2" name="kategoria">Mieszkanie</label></div>
                                <div><label><input type="radio" value="3" name="kategoria">Transport</label></div>
                                <div><label><input type="radio" value="4" name="kategoria">Telekomunikacja</label></div>
                                <div><label><input type="radio" value="5" name="kategoria">Opieka zdrowotna</label></div>
                                <div><label><input type="radio" value="6" name="kategoria">Ubrania</label></div>
                                <div><label><input type="radio" value="7" name="kategoria">Higiena</label></div>
                                <div><label><input type="radio" value="8" name="kategoria">Dzieci</label></div>
                                <div><label><input type="radio" value="9" name="kategoria">Rozrywka</label></div>
                                <div><label><input type="radio" value="10" name="kategoria">Wycieczka</label></div>
                                <div><label><input type="radio" value="11" name="kategoria">Szkolenia</label></div>
                                <div><label><input type="radio" value="12" name="kategoria">Książki</label></div>
                                <div><label><input type="radio" value="13" name="kategoria">Oszczędności</label></div>
                                <div><label><input type="radio" value="14" name="kategoria">Na złotą jesień, czyli emeryturę</label></div>
                                <div><label><input type="radio" value="15" name="kategoria">Spłata długów</label></div>
                                <div><label><input type="radio" value="16" name="kategoria">Darowizna</label></div>
                                <div><label><input type="radio" value="17" name="kategoria">Inne wydatki</label></div>

                            </fieldset>

                            <label><input type="text" name="edytowanaKategoria" placeholder="Nowa nazwa" required></label>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
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
                        <h5 class="modal-title">Wybierz sposób płatności i wpisz jego nową nazwę: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="settings.php" method="post">

                            <fieldset>
                                <label style="font-weight: 700;">Sposób płatności: </label>
                                <div><label><input type="radio" value="g" name="platnosc" checked>Gotówka</label></div>
                                <div><label><input type="radio" value="d" name="platnosc">Karta debetowa</label></div>
                                <div><label><input type="radio" value="k" name="platnosc">Karta kredytowa</label></div>

                            </fieldset>


                            <label><input type="text" name="edytowanaKategoria" placeholder="Nowa nazwa" required></label>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
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
                        <h5 class="modal-title">Wybierz kategorię przychodów do skasowania: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="settings.php" method="post">

                            <label for="kategoria" style="font-weight: 700;"> Kategoria transakcji:</label>
                            <br />
                            <select id="kategoria" name="kategoria" style="width:100%;">

                                <option value="1">Wynagrodzenie</option>
                                <option value="2">Odsetki bankowe</option>
                                <option value="3">Sprzedaż na allegro</option>
                                <option value="4">Inne</option>

                            </select>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
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
                        <h5 class="modal-title">Wybierz kategorię wydatków do skasowania: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="settings.php" method="post">

                            <label for="kategoriadE" style="font-weight: 700;"> Kategoria transakcji:</label>
                            <br />
                            <select id="kategoriadE" name="kategoria" style="width:100%;">

                                <option value="1">Jedzenie</option>
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

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
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
                        <h5 class="modal-title">Wybierz sposób płatności do skasowania: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="settings.php" method="post">

                            <label for="kategoriadP" style="font-weight: 700;"> Kategoria transakcji:</label>
                            <br />
                            <select id="kategoriadP" name="kategoria" style="width:100%;">

                                <option value="1">Gotówka</option>
                                <option value="2">Karta debetowa</option>
                                <option value="3">Karta kredytowa</option>

                            </select>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal editUser-->
        <div class="modal" id="editUserModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wybierz sposób płatności do skasowania: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="settings.php" method="post">

                            <label style="font-weight: 700;"><i class="icon-user"></i><input type="text" name="imie" placeholder="Zmień imię"></label>

                            <label style="font-weight: 700;"><i class="icon-mail-alt"></i><input type="email" name="email" placeholder="Wprowadź email"></label>

                            <label style="font-weight: 700;"><i class="icon-key"></i><input type="password" name="password" placeholder="Zmień hasło"></label>
                            
                            <label style="font-weight: 700;"><i class="icon-key"></i><input type="password" name="password2" placeholder="Powtórz hasło"></label>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                                <input type="submit" class="btn btn-primary" value="Zapisz">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal deleteUser-->
        <div class="modal" id="deleteUserModal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Czy na pewno usunąć użytkownika?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

                        <button type="button" class="btn btn-primary">Usuń</button>
                    </div>
                </div>
            </div>
        </div>




        <article class="walletspage">
            <div class="container">
                <header>
                    <h1 class="font-weight-bold text-uppercase mb-2">Wybierz opcję do zmiany</h1>
                </header>

                <div class="row mb-4">
                    <div class="tileOptionsEdit col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Dodaj kategorie: </h2>
                        <div class="addOptions addOptionIncome d-inline-block" data-toggle="modal" data-target="#addIncomeModal">Przychodów</div>
                        <div class="addOptions addOptionExpense d-inline-block" data-toggle="modal" data-target="#addExpenseModal">Wydatków</div>
                        <div class="addOptions addOptionPay d-inline-block" data-toggle="modal" data-target="#addPayModal">Sposóbów płatności</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="tileOptionsEdit col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Edytuj nazwy kategorii: </h2>
                        <div class="editOptions editOptionIncome d-inline-block" data-toggle="modal" data-target="#editIncomeModal">Przychodów</div>
                        <div class="editOptions editOptionExpense d-inline-block" data-toggle="modal" data-target="#editExpenseModal">Wydatków</div>
                        <div class="editOptions editOptionPay d-inline-block" data-toggle="modal" data-target="#editPayModal">Sposóbów płatności</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="tileOptionsEdit col-12  mb-3">
                        <h2 class="h3 font-weight-bold my-2">Usuń nazwy kategorii: </h2>
                        <div class="deleteOptions deleteOptionIncome d-inline-block" data-toggle="modal" data-target="#deleteIncomeModal">Przychodów</div>
                        <div class="deleteOptions deleteOptionExpense d-inline-block" data-toggle="modal" data-target="#deleteExpenseModal">Wydatków</div>
                        <div class="deleteOptions deleteOptionPay d-inline-block">Sposóbów płatności</div>
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
