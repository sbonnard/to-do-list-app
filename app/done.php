<?php
session_start();

require_once "./includes/_config.php";
require_once "./includes/_database.php";
require_once "./includes/_functions.php";
require_once "./includes/_include.php";
require_once "./includes/_messages.php";

$queryGetTasks = $dbCo->query("SELECT id_task, status, name, date, emergency_level FROM task WHERE status = 'DONE';");
$tasks = $queryGetTasks->fetchAll();

if (!empty($_GET)) {
    redoTask($dbCo);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâches terminées | To Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body>
    <header class="header">
        <a href="#"><img class="header__logo" src="img/logo-jot-m.webp" alt="Logo Jot It"></a>
        <a href="#">
            <h1 class="ttl">Jot It | Do it</h1>
        </a>
        <div class="hamburger">
            <a href="#menu" id="hamburger-menu-icon">
                <img src="img/hamburger.svg" alt="Menu Hamburger">
            </a>
        </div>

        <nav class="hamburger__menu" id="menu" aria-label="Navigation principale du site">
            <ul id="nav-list" class="nav">
                <li class="nav__itm nav__lnk--current">
                    <a href="index.php" class="nav__lnk" aria-current="page">Accueil</a>
                </li>
                <li class="nav__itm">
                    <a href="done.php">Tâches terminées</a>
                </li>
            </ul>
        </nav>
        </div>
    </header>

    <main class="container">

        <section aria-label="Mes tâches terminées" aria-labelledby="donestuff">
            <h2 id="donestuff" class="ttl ttl--bold">C'EST FAIT !</h2>
            <ul>
                <?php
                // GET TASKS FROM DATABASE 
                echo generateDoneTask($tasks);
                ?>
            </ul>
        </section>

        <div class="up">
            <a class="btn--up" href="#" aria-label="Remonter en haut de la page"></a>
        </div>

        <section class="all-done" aria-label="Il n'y a plus de tâches" aria-labelledby="alldone">
            <h2 id="alldone" class="ttl ttl--bold ttl--white">Vous avez bien travaillé !</h2>
        </section>
    </main>

    <footer class="footer">© 2024 | Jot It</footer>

    <script type="module" src="js/script.js"></script>
</body>

</html>