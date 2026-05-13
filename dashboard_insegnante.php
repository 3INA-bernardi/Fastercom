<?php
require_once "components/session.php";
require_once "db/dbutils.php";

if ($_SESSION["ruolo"] !== "Docente") {
  header("Location: login.php");
  exit;
}

$classi = classiDocente($_SESSION["id"]);
$studenti = [];
$classeSelezionata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["classe"])) {
    $classeSelezionata = $_POST["classe"];
    $studenti = studentiPerClasseDocente($_SESSION["id"], $classeSelezionata);
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fastercom - Dashboard Docente</title>
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>
  <?php require_once "components/navbar.php"; ?>

  <main class="dashboard-docente">
    <h1 class="dashboard-title">Dashboard Docente</h1>
    <p class="email"><?= htmlspecialchars($_SESSION["email"]) ?></p>

    <div class="selezione-classe">
      <form method="POST" class="form-classe"> 
        <label for="classe">Seleziona una classe:</label>
        <select name="classe" id="classe" onchange="this.form.submit()">
          <option value=""> -- Seleziona una classe -- </option>
          <?php foreach ($classi as $classe): ?>
            <option value="<?php echo htmlspecialchars($classe['nome']); ?>" 
              <?php echo ($classeSelezionata == $classe['nome']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($classe['nome']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>

    <?php if (!empty($classeSelezionata)): ?>
      <div class="studenti-sezione">
        <h2>Studenti della classe <?= htmlspecialchars($classeSelezionata) ?></h2>

        <?php if (count($studenti) > 0): ?>
          <div class="tabella-container">
            <table class="studenti-tabella">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Cognome</th>
                  <th>Data di Nascita</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($studenti as $studente): ?>
                  <tr>
                    <td><?= htmlspecialchars($studente['nome']) ?></td>
                    <td><?= htmlspecialchars($studente['cognome']) ?></td>
                    <td><?= htmlspecialchars($studente['data_nascita']) ?></td>
                    <td><?= htmlspecialchars($studente['email']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="nessuno-studente">Nessuno studente trovato per questa classe.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </main>

  <?php require_once "components/footer.php"; ?>
</body>

</html>