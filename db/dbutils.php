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

function studentiPerClasseDocente($utenteId, $nomeClasse){
    global $pdo;

    try {
        $sql = "SELECT s.nome, s.cognome, s.data_nascita, u.email 
                FROM studenti s
                JOIN classi c ON s.classe_id = c.id
                JOIN utenti u ON s.utente_id = u.id
                JOIN insegnamenti i ON c.id = i.classe_id
                JOIN docenti d ON i.docente_id = d.id
                WHERE d.utente_id = ? AND c.nome = ?
                ORDER BY s.cognome, s.nome";

        $result = $pdo->prepare($sql);
        $result->execute([$utenteId, $nomeClasse]);

        $studenti = $result->fetchAll(PDO::FETCH_ASSOC);

        return $studenti;
    } catch(PDOException $e){
        echo "<script>alert('Errore" . $e->getMessage() . "')</script>";
        return [];
    }
}

?>