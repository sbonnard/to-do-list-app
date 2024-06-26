<?php
session_start();

require_once "./includes/_database.php";
require_once "./includes/_functions.php";
require_once "./includes/_include.php";
require_once "./includes/_messages.php";

generateToken();

getMessageForNewTask($dbCo);

$queryGetTasks = $dbCo->query("SELECT id_task, status, name, date, emergency_level FROM task WHERE status = 'TO DO';");
$tasks = $queryGetTasks->fetchAll();

// var_dump($_GET);

if (!empty($_GET)) {
    endTask($dbCo);
}

// deleteTask($dbCo);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body>
    <header class="header">
        <img src="img/logo-jot-s.webp" alt="Logo Jot It">
        <h1 class="ttl">Jot It | Do it</h1>
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
        <section aria-label="Mes tâches à faire" aria-labelledby="todo">

            <h2 id="todo" class="ttl ttl--bold">A FAIRE</h2>
            <form class="form" action="" method="post" aria-label="Formulaire d'ajout de tâches">
                <label class="form__label" for="task">Ajouter une tâche</label>
                <input class="form__input" name="name" type="text" placeholder="Faire un truc" required>
                <label class="form__label" for="task">Niveau d'urgence (1-5)</label>
                <input class="form__input" name="emergency_level" type="text" placeholder="1-5" required>
                <input class="form__submit" type="submit" value="✙">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <?php
                echo getErrorMessage($errors);
                echo getSuccessMessage($messages);
                ?>
            </form>
            <ul>
                <?php
                // GET TASKS FROM DATABASE 
                echo generateTask($tasks);
                ?>
            </ul>
        </section>
    </main>

    <footer class="footer">© 2024 | Jot It</footer>

    <script type="module" src="js/script.js"></script>
</body>

</html>