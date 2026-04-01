<?php
require_once "connection.php";

function checkLogin($email, $password){
    global $pdo;

    try{
        $error = "";

        $sql = "SELECT * FROM utenti WHERE email = ?";
        $result = $pdo->prepare($sql);
        $result->execute([$email]);

        $utente = $result->fetch(PDO::FETCH_ASSOC);

        if (empty($utente)) {
            $error = "Email non esistente!";
        }
        else{
            if(!password_verify($password,$utente['password'])){
                $error = "Password errata!";
            }
        }
        return $error;
    }
    catch(PDOException $e){
        echo "<script>alert('Errore" . $e->getMessage() . "')</script>";
    }
}

function getUserByEmail($email){
    global $pdo;

    try{
        $sql = "SELECT ruolo,id FROM utenti WHERE email = ?";
        $result = $pdo->prepare($sql);
        $result->execute([$email]);

        $utente = $result->fetch(PDO::FETCH_ASSOC);
        
        if($utente["ruolo"] === "Docente" || $utente["ruolo"] === "Amministratore"){
            $sql = "SELECT nome,cognome FROM docenti d JOIN utenti u ON d.id = u.id WHERE d.id = ?";
        }else{
            $sql = "SELECT nome,cognome,ruolo FROM studenti s JOIN utenti u ON s.id = u.id WHERE s.id = ?";
        }
        $result = $pdo->prepare($sql);
        $result->execute($utente["id"]);

        $utente = $result->fetch(PDO::FETCH_ASSOC);

        return $utente;
    }
    catch(PDOException $e){
        echo "<script>alert('Errore" . $e->getMessage() . "')</script>";
    }
}
?>