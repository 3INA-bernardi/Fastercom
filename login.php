<?php
require_once "components/session.php";

if(isset($_SESSION['username'])){
    header("Location: dashboard.php");
}

require_once "db/dbutils.php";

$errors = [];
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["email"])) { 
        $errors[] = "Email mancante";
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $errors[] = "Password mancante";
    } else {
        $password = $_POST["password"];
    }

    if (empty($errors)) {
        $loginError = checkLogin($email, $password);
        
        if (empty($loginError)) {
            $utente = getUserByEmail($email);
            $_SESSION["nome"] = $utente['nome'];
            $_SESSION["cognome"] = $utente['cognome']; 
            $_SESSION["ruolo"] = $utente['ruolo'];
            header("Location: dashboard.php"); 
            exit;
        } else {
            $errors[] = $loginError;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Registro ITT Buonarroti</h1>
    </header>
    <?php require_once "components/navbar.php"; ?>
    <main>
        <?php if (!empty($errors)){ ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error){ ?>
                        <li style="color: red"><?= $error ?></li>
                    <?php }; ?>
                </ul>
            </div>
        <?php }; ?>

        <form method="POST">
            <label for="email">Email</label>
            <input 
                type="text"
                name="email"
                placeholder="Inserisci Email...">
            <label for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                placeholder="Inserisci password...">
            <button type="submit">Login</button>
        </form>

    </main>
    <?php require_once "components/footer.php"; ?>
</body>
</html>