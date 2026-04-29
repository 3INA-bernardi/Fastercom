<?php
require_once "components/session.php";
require_once "db/connection.php";



$sql = "SELECT 
            s.nome, 
            s.cognome, 
            s.data_nascita,
            s.codice_fiscale,
            u.email, 
            u.password_hash AS password, 
            c.nome AS classe
        FROM studenti s
        INNER JOIN utenti u ON s.utente_id = u.id
        LEFT JOIN classi c ON s.classe_id = c.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$studenti = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT nome
FROM classi";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$classe = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <div class="dashboard-flex">
        <div class="studenti-lista">
            <h2>Studenti</h2>

            <?php if (count($studenti) > 0): ?>
                <table class="studenti-tabella">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Data di nascita</th>
                            <th>Codice Fiscale</th>
                            <th>Classe</th>                           
                            <th>Email</th>
                            <th>Password</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($studenti as $studente): ?>
                            <tr>
                                <td><?= htmlspecialchars($studente['nome']) ?></td>
                                <td><?= htmlspecialchars($studente['cognome']) ?></td>
                                <td><?= htmlspecialchars($studente['data_nascita']) ?></td>
                                <td><?= htmlspecialchars($studente['codice_fiscale']) ?></td>
                                <td><?= htmlspecialchars($studente['classe']) ?></td>
                                <td><?= htmlspecialchars($studente['email']) ?></td>
                                <td><?= htmlspecialchars($studente['password']) ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nessuno studente trovato</p>
            <?php endif; ?>
        </div>

        <div class="studenti-form">
            <form class="form">
                <input placeholder="Nome" class="input" type="text">
                <input placeholder="Cognome" class="input" type="text">
                <input placeholder="Data di nascita" class="input" type="date">
                <input placeholder="Codice Fiscale" class="input" type="text">

                <select name="classe" id="classe">
                    <option value=""> -- Seleziona una classe -- </option>
                    <?php foreach ($classe as $c): ?>
                        <option value="<?= $c['nome']; ?>">
                            <?= $c['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input placeholder="Email" class="input" type="email">
                <input placeholder="Password" class="input" type="password">
                <button>Aggiungi Studente</button>
            </form>
        </div>



    </div>
</div>
</main>

<?php require_once "components/footer.php"; ?>

</body>
</html>
