<?php
session_start();

require_once "./includes/_config.php";
require_once "./includes/_database.php";
require_once "./includes/_functions.php";
require_once "./includes/_include.php";
require_once "./includes/_messages.php";

generateToken();

getMessageForNewTask($dbCo);

$queryGetTasks = $dbCo->query("SELECT id_task, status, name, date, emergency_level FROM task WHERE status = 'TO DO' ORDER BY date DESC;");
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
        <img class="header__logo" src="img/logo-jot-m.webp" alt="Logo Jot It">
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

            <h2 id="todo" class="ttl ttl--bold">À FAIRE</h2>
            <form class="form" action="" method="post" aria-label="Formulaire d'ajout de tâches">
                <label class="form__label" for="task">Ajouter une tâche</label>
                <input class="form__input" name="name" type="text" placeholder="Faire un truc" required>
                <label class="form__label" for="emergency_level">Niveau d'urgence (1-5)</label>
                <input class="form__input" name="emergency_level" type="text" placeholder="1-5" required>
                <input class="form__submit" type="submit" value="">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <?php
                echo getErrorMessage($errors);
                echo getSuccessMessage($messages);
                ?>
            </form>

            <div class="form">
                <button id="btn-modifier" class="btn--pen"></button>
            </div>

            <form id="form-modifier" class="form hidden" action="" method="post" aria-label="Formulaire de modification d'une tâche existante">
                <label class="form__label" for="numbertask">Numéro de la tâche à modifier</label>
                <input class="form__input" name="numbertask" type="text" placeholder="111" required>
                <label class="form__label" for="task">Nouveau nom de la tâche</label>
                <input class="form__input" name="name" type="text" placeholder="Faire un truc" required>
                <label class="form__label" for="new_emergency_level">Niveau d'urgence (1-5)</label>
                <input class="form__input" name="new_emergency_level" type="text" placeholder="1-5" required>
                <input class="btn" type="submit" value="Modifier">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
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