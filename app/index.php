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
            <ul id="errorsList" class="errors"></ul>
            <ul id="messagesList" class="messages"></ul>

            <section aria-label="Boite à outils">
                <div id="toolbox" class="container--btn">
                    <button id="btn-tool" class="btn--square btn--tool" aria-label="Ouvrir les outils de modification des tâches"></button>
                    <button id="btn-modifier" class="btn--pen hidden" aria-label="Modifier une tâche"></button>
                    <button id="btn-priority" class="btn--square btn--priority hidden" aria-label="Modifier une tâche"></button>
                    <!-- <button id="btn-minus" class="btn--square btn--minus hidden" aria-label="Supprimer une tâche"></button> -->
                    <button id="btn-theme" class="btn--square btn--theme hidden" aria-label="Créer un thème de tâche"></button>
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

            <form id="form-new-theme" class="form hidden" action="actions.php" method="post" aria-label="Formulaire de suppression d'une tâche existante">
                <h3 class="ttl ttl--small">Créer un nouveau thème</h3>
                <label class="form__label" for="new-theme">Nom du thème</label>
                <input class="form__input" name="new-theme" type="text" placeholder="Voyage, travail..." required>
                <input class="btn" type="submit" value="Ajouter">
                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <input type="hidden" name="action" value="new-theme">
            </form>

            <ul class="tasklist" data-task-list="">
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

    <!-- Template for errors in JS  -->
    <template id="templateError">
        <li data-error-message="" class="notif notif--error">Ici vient le message d'erreur</li>
    </template>

    <template id="templateMessage">
        <li data-message="" class="notif notif--success">Ici vient le message</li>
    </template>

    <!-- <template id="templateGenerateTask">
    <li class="task" data-end-task-content-id=" {{ $task['id_task'] }} " data-template-create="">
            <div class="task__content">
                <p class="task__number-symbol">N°<span class="task__number" data-template-task-id="">{{ $task['id_task'] }}</span></p>
                <h3 class="ttl ttl--small" data-template-task-name="">{{ $task['name'] }}</h3>
                <button type="button" data-delete-task-id=" {{ $task['id_task'] }} " class="btn--square btn--minus"></button>
            </div>
            <div class="task__content task__themes">
                <a class="lnk--theme" href="?action=set-theme&id={{$task['id_task']}}"></a>
                <p> FUNCTION HERE {{displayIfThemeSet($task, $dbCo)}} </p>
            </div>
            <div class="task__content task__content--date-and-level">
                <div class="task-content task-content--deadline">
                    <p>Deadline:
                        <a class="deadline" href="?action=deadline&id={{$task['id_task']}}">Ajouter une deadline 📆</a>
                    </p>
                </div>
                <p>Niveau <span class="task__number" data-template-task-priority="">{{ $task['emergency_level'] }}</span></p>
            </div>
            <button type="button" data-end-task-id=" {{$task['id_task']}} " class="btn js-end-task-btn">C’est fait !</button>
        </li>
    </template> -->

    <script type="module" src="js/index.js"></script>
    <script type="module" src="js/script.js"></script>
    <script type="module" src="js/async-index.js"></script>
</body>

</html>