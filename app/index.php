<?php

try {
    $dbCo = new PDO(
        'mysql:host=db;dbname=jotit_doit;charset=utf8',
        'app-crud',
        'dwwm2024'
    );
    $dbCo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (EXCEPTION $error) {
    die('Échec de la connexion à la base de donnée.' . $error->getMessage());
}
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
            <ul id="nav-list">
                <li>
                    <a href="index.html" class="nav__lnk" aria-current="page">Accueil</a>
                </li>
                <li class="nav__itm nav__lnk--current">
                    <a href="done.html">Tâches terminées</a>
                </li>
            </ul>
        </nav>
        </div>
    </header>

    <main class="container">
        <h2 class="ttl ttl--bold">A FAIRE</h2>
        <form class="form" action="" method="post" aria-label="Formulaire d'ajout de tâches">
            <label class="form__label" for="task">Ajouter une tâche</label>
            <input class="form__input" type="text" placeholder="Faire un truc" required>
            <label class="form__label" for="task">Niveau d'urgence (1-5)</label>
            <input class="form__input" type="text" placeholder="1-5" required>
            <input class="form__submit" type="submit" value="✙">
        </form>
        <section>
            <ul>
                <?php
                $query = $dbCo->query("SELECT name, date, emergency_level
FROM task;");
                $tasks = $query->fetchAll();

                foreach ($tasks as $task) {
                    echo '<li class="task">'
                    . '<div class="task__content"><h3 class="ttl ttl--small">' . $task['name'] . '</h3>' 
                    . '<button class="btn--minus">-</button></div>'
                    . '<div class="task__content"><p>' . $task['date'] . '</p>' 
                    . '<p>Niveau <span class="task__number">' . $task['emergency_level'] . '</span></p></div>
                    .<button class="btn">C’est fait !</button></li>';
                }
                ?>
            </ul>
            <!-- <img src="./img/minus-btn.svg" alt="Bouton de suppression de tâche"> -->
        </section>
    </main>

    <footer class="footer">© 2024 | Jot It</footer>

    <script type="module" src="js/script.js"></script>
</body>

</html>