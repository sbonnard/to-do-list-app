<?php
session_start();

require_once "./includes/_config.php";
require_once "./includes/_database.php";
require_once "./includes/_queries.php";
require_once "./includes/_functions.php";
require_once "./includes/_messages.php";

generateToken();
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
        <!-- CONNECTION FORM -->
        <section class="container form--connection bg-blur" aria-labelledby="connexion grid-form">
            <h2 class="ttl ttl--bold" id="connexion">connexion</h2>
            <form action="login.php" method="post" aria-label="Formulaire de connexion">
                <ul class="form__container">
                    <li class="form__itm">
                        <label class="input__label" for="username">Email</label>
                        <input class="input" type="text" name="email" id="email" placeholder="rôliste@rolist-mingle.fr"
                            required aria-label="Entrez votre email">
                    </li>
                    <li class="form__itm">
                        <label class="input__label" for="password">Mot de passe</label>
                        <div class="input--password">
                            <input class="input" type="password" name="password" id="password" placeholder="•••••••••••"
                                required aria-label="Merci d'entrer votre mot de passe">
                            <button type="button" class="button--eye button--eye--inactive" id="eye-button"
                                aria-label="Montrer le mot de passe en clair dans le champs de saisie"></button>
                        </div>
                    </li>
                    <!-- <p class="button__lnk"><a href="forgotten-password.php">Mot de passe oublié ?</a></p> -->
                    <input class="button" type="submit" value="Se connecter">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <input type="hidden" name="action" value="log-in">
                </ul>
            </form>
        </section>
    </main>

    <footer class="footer">© 2024 | Jot It</footer>

    <!-- Template for errors in JS  -->
    <template id="templateError">
        <li data-error-message="" class="notif notif--error">Ici vient le message d'erreur</li>
    </template>

    <template>
        <li class="task" data-end-task-content-id=" {{ $task['id_task'] }} ">
            <div class="task__content">
                <p class="task__number-symbol">N°<span class="task__number">{{ $task['id_task'] }}</span></p>
                <h3 class="ttl ttl--small">{{ $task['name'] }}</h3>
                <button type="button" data-delete-task-id=" {{ $task['id_task'] }} "
                    class="btn--square btn--minus"></button>
            </div>
            <div class="task__content task__themes">
                <a class="lnk--theme" href="?action=set-theme&id={{$task['id_task']}}"></a>
                <p> FUNCTION HERE {{displayIfThemeSet($task, $dbCo)}} </p>
            </div>
            <div class="task__content task__content--date-and-level">
                <p> {{$task['date']}} </p>
                <p>Niveau <span class="task__number"> {{ $task['emergency_level'] }} </span></p>
            </div>
            FUNCTION HERE displayIfDeadline($task)
            <button type="button" data-end-task-id=" {{$task['id_task']}} " class="btn js-end-task-btn">C’est fait
                !</button>
        </li>
    </template>

    <script type="module" src="js/index.js"></script>
    <script type="module" src="js/script.js"></script>
    <script type="module" src="js/async-index.js"></script>
</body>

</html>