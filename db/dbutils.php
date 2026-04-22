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
            if(!password_verify($password,$utente['password_hash'])){
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
        $sql = "SELECT id, ruolo FROM utenti WHERE email = ?";
        $result = $pdo->prepare($sql);
        $result->execute([$email]);

        $utente = $result->fetch(PDO::FETCH_ASSOC);

        return $utente;
    }
    catch(PDOException $e){
        echo "<script>alert('Errore" . $e->getMessage() . "')</script>";
    }
}

function classiDocente($id){
    global $pdo;

    try {
        $sql = "SELECT c.nome FROM docenti d
        JOIN insegnamenti i ON d.id = i.docente_id 
        JOIN classi c ON i.classe_id = c.id WHERE d.utente_id = ?";
        $result = $pdo->prepare($sql);
        $result->execute([$id]);

        $classi = $result->fetchAll(PDO::FETCH_ASSOC);

        return $classi;
    } catch(PDOException $e){
        echo "<script>alert('Errore" . $e->getMessage() . "')</script>";
    }
}

?>