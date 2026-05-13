<?php
require_once "components/session.php";



if ($_SESSION["ruolo"] === "Studente") {
    header("Location: dashboard_studente.php");
    exit;
} elseif ($_SESSION["ruolo"] === "Docente") {
    header("Location: dashboard_insegnante.php");
    exit;
} elseif ($_SESSION["ruolo"] === "Amministratore") {
    header("Location: dashboard_amministratore.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
