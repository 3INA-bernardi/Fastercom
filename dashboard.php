<?php

require_once "components/session.php";

if(($_SESSION["ruolo"])=="Studente"){
    header("Location: dashboard_studente.php");
}else if(($_SESSION["ruolo"])=="Docente"){
    header("Location: dashboard_insegnante.php");
}else{
    echo"AURA ";
}