<?php
require_once "components/session.php";
require_once "db/connection.php";

if ($_POST) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $classe = $_POST['classe'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql_utente = "INSERT INTO utenti (email, password_hash, ruolo) VALUES (?, ?, 'Docente')";
    $stmt_utente = $pdo->prepare($sql_utente);
    $stmt_utente->execute([$email, $password_hash]);
    $utente_id = $pdo->lastInsertId();

    $sql_docente = "INSERT INTO docenti (utente_id, nome, cognome) VALUES (?, ?, ?)";
    $stmt_docente = $pdo->prepare($sql_docente);
    $stmt_docente->execute([$utente_id, $nome, $cognome]);
    $docente_id = $pdo->lastInsertId();

    if (!empty($classe)) {
        $sql_classe = "SELECT id FROM classi WHERE nome = ?";
        $stmt_classe = $pdo->prepare($sql_classe);
        $stmt_classe->execute([$classe]);
        $classe_aura = $stmt_classe->fetch(PDO::FETCH_ASSOC);

        if ($classe_aura) {
            $classe_id = $classe_aura['id'];
            $sql_insegnamento = "INSERT INTO insegnamenti (docente_id, classe_id) VALUES (?, ?)";
            $stmt_insegnamento = $pdo->prepare($sql_insegnamento);
            $stmt_insegnamento->execute([$docente_id, $classe_id]);
        }
    }
}

$sql = "SELECT 
            d.nome, 
            d.cognome,
            c.nome AS classe,
            u.email, 
            u.password_hash AS password
        FROM docenti d
        INNER JOIN utenti u ON d.utente_id = u.id
        LEFT JOIN insegnamenti i ON d.id = i.docente_id
        LEFT JOIN classi c ON i.classe_id = c.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$docenti = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT nome
FROM classi";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$classi = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h2>Docenti</h2>

            <?php if (count($docenti) > 0): ?>
                <table class="studenti-tabella">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Classe</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($docenti as $docente): ?>
                            <tr>
                                <td><?= htmlspecialchars($docente['nome']) ?></td>
                                <td><?= htmlspecialchars($docente['cognome']) ?></td>
                                <td><?= htmlspecialchars($docente['classe']) ?></td>
                                <td><?= htmlspecialchars($docente['email']) ?></td>
                                <td><?= htmlspecialchars($docente['password']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nessun docente trovato</p>
            <?php endif; ?>
        </div>

        <div class="studenti-form">
            <form class="form" method="post" action="">
                <input placeholder="Nome" class="input" type="text" name="nome" required>
                <input placeholder="Cognome" class="input" type="text" name="cognome" required>

                <select name="classe" id="classe" required>
                    <option value=""> -- Seleziona una classe -- </option>
                    <?php foreach ($classi as $c): ?>
                        <option value="<?= htmlspecialchars($c['nome']); ?>">
                            <?= htmlspecialchars($c['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input placeholder="Email" class="input" type="email" name="email" required>
                <input placeholder="Password" class="input" type="password" name="password" required>
                <button type="submit">Aggiungi Docente</button>
            </form>
        </div>

    </div>
</div>
</main>

<?php require_once "components/footer.php"; ?>

</body>
</html>
