<?php
require_once "components/session.php";
require_once "db/connection.php";

$sql = "SELECT m.nome, d.cognome
FROM insegnamenti i
JOIN studenti s ON s.classe_id = i.classe_id
JOIN materie m ON m.id = i.materia_id
JOIN docenti d ON d.id = i.docente_id
WHERE s.utente_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION["id"]]);
$materie = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        <h2>Le tue materie</h2>

        <?php if (count($materie) > 0): ?>
            <div class="card-container">
                <?php foreach ($materie as $materia): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($materia['nome']) ?></h3>
                        <p>Docente: <?= htmlspecialchars($materia['cognome']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nessuna materia trovata</p>
        <?php endif; ?>
    </div>
</main>

<?php require_once "components/footer.php"; ?>

</body>
</html>