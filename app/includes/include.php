<?php

// CONNECTION 
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

// CREATE NEW TASKS 
if (!empty($_POST)) {
    if (isset($_SERVER['HTTP_REFERER']) && str_contains($_SERVER['HTTP_REFERER'], 'http://localhost:8282')) {
        if (isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] === $_POST['token']) {
            if (
                isset($_POST['name'])
                && strlen($_POST['name']) > 0
                && strlen($_POST['name']) < 50
                && isset($_POST['emergency_level'])
                && is_numeric($_POST['emergency_level'])
                && $_POST['emergency_level'] > 0
                && $_POST['emergency_level'] <= 5
            ) {
                $insert = $dbCo->prepare("INSERT INTO task (`name`, `date`, `emergency_level`)
VALUES (:name, CURDATE(), :emergency_level);");

                $bindValues = [
                    'name' => htmlspecialchars($_POST['name']),
                    'emergency_level' => round($_POST['emergency_level'])
                ];

                $isInsertOk = $insert->execute($bindValues);

                $nb = $insert->rowCount();

                $newRefProduct = $dbCo->lastInsertId();

                var_dump($isInsertOk, $nb, $newRefProduct);
            }
        } else {
            var_dump('Erreur de token');
        }
    }
}


// GET TASKS FROM DATABASE 
$queryGetTasks = $dbCo->query("SELECT name, date, emergency_level FROM task;");
$tasks = $queryGetTasks->fetchAll();

function generateTask (array $taskarray) {
    $allTasks = '';
    foreach ($taskarray as $task) {
       $allTasks .=  '<li class="task">'
            . '<div class="task__content"><button>'
            . '<img class="btn--pen" src="./img/pen-btn.svg" alt="Bouton de modification du nom d\'une tâche">'
            . '</button><h3 class="ttl ttl--small">'
            . $task['name'] . '</h3>'
            . '<button class="btn--minus">-</button></div>'
            . '<div class="task__content"><p>'
            . $task['date']
            . '</p>'
            . '<p>Niveau <span class="task__number">'
            . $task['emergency_level']
            . '</span></p></div><button class="btn">C’est fait !</button></li>';
    }
    return $allTasks;
}
