<?php

session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = md5(uniqid(mt_rand(), true));
}

include "./includes/include.php";


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="css/style.css">
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
                    <a href="index.html" class="nav__lnk" aria-current="page">Accueil</a>
                </li>
                <li class="nav__itm">
                    <a href="done.html">Tâches terminées</a>
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
            </form>
            <ul>
                <?php
                // GET TASKS FROM DATABASE 
                $queryGetTasks = $dbCo->query("SELECT id_task, name, date, emergency_level FROM task;");
                $tasks = $queryGetTasks->fetchAll();

                echo generateTask($tasks);

                ?>
            </ul>
        </section>
    </main>

    <footer class="footer">© 2024 | Jot It</footer>

    <script type="module" src="js/script.js"></script>
</body>

</html>