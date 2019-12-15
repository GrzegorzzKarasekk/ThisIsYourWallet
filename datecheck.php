<?php
session_start();
	
    if(!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }

    $dataczas = new DateTime();
    $datadomyslna = $dataczas->format('d-m-Y');

    $firstdayThisMonth = date("d-m-Y", strtotime("first day of this month"));
    $lastdayThisMonth = date("d-m-Y", strtotime("last day of this month"));

    


    if (isset($_POST['niestandardowydzien1']))
    {

        //echo $_POST['niestandardowydzien1'].'<br />';
        //echo $_POST['niestandardowydzien2'].'<br />';
        
        
        $wszystko_OK=true;

        $dataczas1 = new DateTime($_POST['niestandardowydzien1']);
        $_SESSION['niestandardowydzien1']= $dataczas1->format('d-m-Y');
        $dataczas2 = new DateTime($_POST['niestandardowydzien2']);
        $_SESSION['niestandardowydzien2']= $dataczas2->format('d-m-Y');
        
        if($firstdayThisMonth == $_SESSION['niestandardowydzien1'] && $lastdayThisMonth == $_SESSION['niestandardowydzien2'])
        {
           header('Location:przegladaj-bilans');
           exit(); 
        }
        
        elseif($_SESSION['niestandardowydzien1'] > $datadomyslna)
        {
            $wszystko_OK=false;
            $_SESSION['e_date']="Data nie może być większa od dzisiejszej!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            $_SESSION['niestandardowydzien1'] = $datadomyslna;
            $_SESSION['niestandardowydzien2'] = $datadomyslna;
            exit();
        }
        elseif($_SESSION['niestandardowydzien1'] > $_SESSION['niestandardowydzien2'])
        {
            $wszystko_OK=false;
            $_SESSION['e_date']="Data perwsza nie może być większa od daty drugiej!";
            header('Location:'.$_SERVER['HTTP_REFERER']);
            $_SESSION['niestandardowydzien1'] = $datadomyslna;
            $_SESSION['niestandardowydzien2'] = $datadomyslna;
            exit();
        }
        else
        {
           header('Location:wybrany-okres');
           exit(); 
        }
        
    }
?>