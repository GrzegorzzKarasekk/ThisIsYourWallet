<?php

	session_start();
    if(!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }
   
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();                   
?>