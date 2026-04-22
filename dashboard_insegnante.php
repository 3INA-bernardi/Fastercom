<?php
require_once "components/session.php";
require_once "db/dbutils.php";

if ($_SESSION["ruolo"] !== "Docente") {
  header("Location: login.php");
}

$classi = classiDocente($_SESSION["id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
}
?>


<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="assets/dashboardInsegnati.css">
</head>

<body>
  <?php require_once "components/navbar.php"; ?>
  <form method="POST"> 
  <label for="classe">Classe</label>
  <select name="classe" id="classe" onchange="this.form.submit()">
    <option value=""> -- Seleziona una classe -- </option>
    <?php foreach ($classi as $classe): ?>
      <option value="<?php echo $classe['nome']; ?>" 
        <?php echo (isset($_POST['classe']) && $_POST['classe'] == $classe['nome']) ? 'selected' : ''; ?>>
        <?php echo $classe['nome']; ?>
      </option>
    <?php endforeach; ?>
  </select>
</form>
  <?php require_once "components/footer.php"; ?>
</body>

</html>