<?php
require_once "components/session.php";
require_once "db/connection.php";

if ($_SESSION["ruolo"] !== "Amministratore") {
  header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fastercom - Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<?php require_once "components/navbar.php"; ?>
<main>
    <div class="admin-dashboard">
        <h1 class="dashboard-title">Pannello Amministrazione</h1>
        
        <div class="admin-buttons-container">
            <a href="studenti.php" class="admin-btn admin-btn-studenti">
                <span class="btn-icon">👨‍🎓</span>
                <span class="btn-text">Studenti</span>
            </a>
            
            <a href="insegnanti.php" class="admin-btn admin-btn-insegnanti">
                <span class="btn-icon">🧑‍🏫</span>
                <span class="btn-text">Insegnanti</span>
            </a>
            
            <a href="materie.php" class="admin-btn admin-btn-materie">
                <span class="btn-icon">📚</span>
                <span class="btn-text">Materie</span>
            </a>
        </div>
    </div>
</main>
<?php require_once "components/footer.php"; ?>

</body>
</html>