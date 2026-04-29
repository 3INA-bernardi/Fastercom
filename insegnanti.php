<?php
require_once "components/session.php";
require_once "db/connection.php";

if ($_SESSION["ruolo"] !== "Amministratore") {
  header("Location: login.php");
}

$sql = "SELECT i.nome, i.cognome
FROM insegnanti i";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$insegnanti = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="dashboard">
        <h1>Benvenuto</h1>
        <p class="email"><?= htmlspecialchars($_SESSION["email"]) ?></p>

        <h2>Insegnanti</h2>

        <?php if (count($insegnanti) > 0): ?>
            <div class="card-container">
                <?php foreach ($insegnanti as $insegnante): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($insegnante['nome']) ?> <?= htmlspecialchars($insegnante['cognome']) ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nessuno insegnante trovato trovato</p>
        <?php endif; ?>
    </div>
</main>
<?php require_once "components/footer.php"; ?>
</body>
</html>