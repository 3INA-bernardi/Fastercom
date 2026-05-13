<?php
require_once "components/session.php";
require_once "db/connection.php";

if ($_SESSION["ruolo"] !== "Amministratore") {
  header("Location: login.php");
}

if ($_POST) {
    $nome = $_POST['nome'];

    $sql_utente = "INSERT INTO materie (nome) VALUES (?)";
    $stmt_utente = $pdo->prepare($sql_utente);
    $stmt_utente->execute([$nome]);
}

$sql = "SELECT nome
FROM materie";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$materie = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fastercom - Docenti</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<?php require_once "components/navbar.php"; ?>
<main>  
    <div class="dashboard">
    <h1>Benvenuto</h1>

    <div class="dashboard-flex">
        <div class="studenti-lista">
            <h2>Materie</h2>

            <?php if (count($materie) > 0): ?>
                <table class="studenti-tabella">
                    <thead>
                        <tr>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materie as $materie): ?>
                            <tr>
                                <td><?= htmlspecialchars($materie['nome']) ?></td>  
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nessuna materia trovata</p>
            <?php endif; ?>
        </div>

        <div class="studenti-form">
            <form class="form" method="post" action="">
                <input placeholder="Nome materia" class="input" type="text" name="nome" required>
                <button type="submit">Aggiungi materia</button>
            </form>
        </div>

    </div>
</div>
</main>

<?php require_once "components/footer.php"; ?>

</body>
</html>
