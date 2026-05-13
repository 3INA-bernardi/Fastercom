<?php
require_once "session.php";
?>
<<header class="site-header">
    <div class="header-title">
        <h1>Liceo P. Lodron</h1>
        <p>Accesso rapido alle tue pagine</p>
    </div>

    <nav class="main-nav">
        <?php if (isset($_SESSION["ruolo"])): ?>
            <?php if ($_SESSION["ruolo"] === "Studente"): ?>
                <a href="dashboard_studente.php">Dashboard</a>
            <?php elseif ($_SESSION["ruolo"] === "Docente"): ?>
                <a href="dashboard_insegnante.php">Dashboard</a>
            <?php elseif ($_SESSION["ruolo"] === "Amministratore"): ?>
                <a href="dashboard_amministratore.php">Dashboard</a>
            <?php endif; ?>
            
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>