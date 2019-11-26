<?php

$imie = "Bakłażan";
$nazwisko = "Kwaśniewski";

// konstrukcja wyrażenia regularnego
// poprawność imienia oraz nazwiska
$sprawdz = '/^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';

// ereg() sprawdza dopasowanie wzorca do ciągu
// zwraca true jeżeli tekst pasuje do wyrażenia
if(ereg($sprawdz, $imie)) 
{
   if(preg_match($sprawdz, $nazwisko))
      echo "Podano poprawne dane.";
   else
      echo "Błędne nazwisko.";
}
else 
   echo "Błędne imię.";

?>