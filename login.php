<?php
require_once "components/session.php";

if (isset($_SESSION['username'])) {
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
            $_SESSION["email"] = $utente['email'];
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
    <link rel="stylesheet" href="assets/style.css" >
    <link rel="stylesheet" href="assets/login.css" >
</head>

<body>
    <header>
        <h1>Liceo P. Lodron</h1>
    </header>
    <?php require_once "components/navbar.php"; ?>
    <main>
        <?php if (!empty($errors)) { ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li style="color: red"><?= $error ?></li>
                    <?php }; ?>
                </ul>
            </div>
        <?php }; ?>

        <form method="post" class="form">
            <p class="form-title">Accedi al tuo account</p>
            <div class="input-container">
                <input placeholder="Inserisci email" type="email" name="email" id="email">
                <span>
                    <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </span>
            </div>
            <div class="input-container">
                <input placeholder="Enter password" type="password" name="password" id="password">

                <span>
                    <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </span>
            </div>
            <button class="submit" type="submit">
                Accedi
            </button>

        </form>

    </main>
    <?php require_once "components/footer.php"; ?>
</body>

</html>