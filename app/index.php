<?php
session_start();

require_once "./includes/_config.php";
require_once "./includes/_database.php";
require_once "./includes/_queries.php";
require_once "./includes/_functions.php";
require_once "./includes/_messages.php";

generateToken();

// var_dump($_GET);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jot It | Do it</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body>
    <header class="header">
        <a href="index.php"><img class="header__logo" src="img/logo-jot-m.webp" alt="Logo Jot It"></a>
        <a href="index.php">
            <h1 class="ttl">Jot It <span class="header__separator">|</span> Do it</h1>
        </a>
        <div class="hamburger">
            <a href="#menu" id="hamburger-menu-icon">
                <img src="img/hamburger.svg" alt="Menu Hamburger">
            </a>
        </div>

        <nav class="hamburger__menu" id="menu" aria-label="Navigation principale du site">
            <ul id="nav-list" class="nav">
                <li class="nav__itm">
                    <a href="index.php" class="nav__lnk nav__lnk--current" aria-current="page">Accueil</a>
                </li>
                <li class="nav__itm">
                    <a href="done.php">Tâches terminées</a>
                </li>
            </ul>
        </nav>
        </div>
    </header>

    <main class="container">
        <section aria-label="Mes tâches à faire " aria-labelledby="todo">

            <h2 id="todo" class="ttl ttl--bold">À FAIRE</h2>
            <?php
            echo getAddTaskForm($_GET, $_SESSION);
            echo setDeadlineForm($_GET);
            echo getAddThemeForm($_GET, $_SESSION, $themes, $dbCo);
            echo getNotif($notifs);
            echo getErrorMessage($errors);
            echo getSuccessMessage($messages);
            ?>
            <section aria-label="Boite à outils">
                <div id="toolbox" class="container--btn">
                    <button id="btn-tool" class="btn--tool" aria-label="Ouvrir les outils de modification des tâches"></button>
                    <button id="btn-modifier" class="btn--pen hidden" aria-label="Modifier une tâche"></button>
                    <button id="btn-priority" class="btn--priority hidden" aria-label="Modifier une tâche"></button>
                    <button id="btn-minus" class="btn--minus hidden" aria-label="Supprimer une tâche"></button>
                    <button id="btn-theme" class="btn--theme hidden" aria-label="Créer un thème de tâche"></button>
                </div>
            </section>

            <form id="form-modifier" class="form hidden" action="actions.php" method="post" aria-label="Formulaire de modification d'une tâche existante">
                <h3 class="ttl ttl--small">Modifier une tâche</h3>
                <label class="form__label" for="numbertask">Numéro de la tâche à modifier</label>
                <input class="form__input" name="numbertask" type="text" placeholder="111" required>
                <label class="form__label" for="newname">Nouveau nom de la tâche</label>
                <input class="form__input" name="newname" type="text" placeholder="Faire un truc" required>
                <input class="btn" type="submit" value="Modifier">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <input type="hidden" name="action" value="modify">
            </form>

            <form id="form-emergency" class="form hidden" action="actions.php" method="post" aria-label="Formulaire de modification de priorité d'une tâche">
                <h3 class="ttl ttl--small">Modifier l'ordre de priorité</h3>
                <label class="form__label" for="numbertask_emergency">Numéro de la tâche à modifier</label>
                <input class="form__input" name="numbertask_emergency" type="text" placeholder="111" required>
                <label class="form__label" for="new_emergency_level">Niveau d'urgence</label>
                <input class="form__input" name="new_emergency_level" type="text" placeholder="1-255" required>
                <input class="btn" type="submit" value="Modifier">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <input type="hidden" name="action" value="modify_emergency">
            </form>

            <form id="form-delete" class="form hidden" action="actions.php" method="post" aria-label="Formulaire de suppression d'une tâche existante">
                <h3 class="ttl ttl--small">Supprimer une tâche</h3>
                <label class="form__label" for="numbertask_delete">Numéro de la tâche à supprimer</label>
                <input class="form__input" name="numbertask_delete" type="text" placeholder="111" required>
                <input class="btn" type="submit" value="Supprimer">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <input type="hidden" name="action" value="delete">
            </form>

            <form id="form-new-theme" class="form hidden" action="actions.php" method="post" aria-label="Formulaire de suppression d'une tâche existante">
                <h3 class="ttl ttl--small">Créer un nouveau thème</h3>
                <label class="form__label" for="new-theme">Nom du thème</label>
                <input class="form__input" name="new-theme" type="text" placeholder="Voyage, travail..." required>
                <input class="btn" type="submit" value="Ajouter">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <input type="hidden" name="action" value="new-theme">
            </form>

            <ul class="tasklist">
                <?php
                // GET TASKS FROM DATABASE 
                echo generateTask($tasks, $dbCo);
                ?>
            </ul>
        </section>

        <div class="up">
            <a class="btn--up" href="#" aria-label="Remonter en haut de la page"></a>
        </div>

        <section class="all-done" aria-label="Il n'y a plus de tâches" aria-labelledby="alldone">
            <h2 id="alldone" class="ttl ttl--bold ttl--white">Il n'y a plus de tâches !</h2>
        </section>
        <form action="actions.php" method="post" aria-hidden="true">
            <input id="token" type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        </form>
    </main>

    <footer class="footer">© 2024 | Jot It</footer>
    <script type="module" src="js/index.js"></script>
    <script type="module" src="js/script.js"></script>
    <script type="module" src="js/async-index.js"></script>
</body>

</html>