<?php

	session_start();

    require_once "connect.php";//require Wymaga pliku w kodzie, once dołączy jeżeli nie został już wcześniej.

    mysqli_report(MYSQLI_REPORT_STRICT);
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    //Ogonki
        mysqli_query($polaczenie, "SET CHARSET utf8");
        mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    //
    $sql="DROP TABLE wynik_wydatkow_uzytkownika_za_okres";
    $polaczenie->query($sql);
    $polaczenie->close();
    	
	session_unset();
	
	header('Location: index.php');

?>