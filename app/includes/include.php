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
// $queryGetTasks = $dbCo->query("SELECT id_task, status, name, date, emergency_level FROM task WHERE status = 'TO DO';");
// $tasks = $queryGetTasks->fetchAll();

function generateTask(array $taskarray)
{
    $allTasks = '';
    foreach ($taskarray as $task) {
        var_dump($task['id_task']);
        $allTasks .=  '<li class="task">'
            . '<div class="task__content"><button>'
            . '<img class="btn--pen" src="./img/pen-btn.svg" alt="Bouton de modification du nom d\'une tâche">'
            . '</button><h3 class="ttl ttl--small">'
            . $task['name'] . '</h3>'
            . '<a href="?id='
            . $task['id_task'] 
            . '" class="btn--minus">-</a></div>'
            . '<div class="task__content"><p>'
            . $task['date']
            . '</p>'
            . '<p>Niveau <span class="task__number">'
            . $task['emergency_level']
            . '</span></p></div><a href="?id='
            . $task['id_task']
            . '" class="btn">C’est fait !</a></li>';
    }
    return $allTasks;
}

// $queryUpdateTaskStatus = $dbCo->query("UPDATE task SET status = 'DONE' WHERE id_task = $_GET;");

// $taskUpdate = $queryUpdateTaskStatus->fetchAll();

/**
 * Switch a task to done and delete it from the DOM and no the database.
 *
 * @param PDO $dbCo 
 * @return void
 */
function endTask(PDO $dbCo)
{
    if (!empty($_GET)) {
        $queryUpdateTaskStatus = $dbCo->prepare("UPDATE task SET status = 'DONE' WHERE id_task = :id;");

        $taskUpdate = $queryUpdateTaskStatus->fetchAll();

        $bindValues = [
            'id' => htmlspecialchars($_GET['id']),
        ];

        $isUpdatetOk = $queryUpdateTaskStatus->execute($bindValues);
    }
    return $taskUpdate;
}


// function deleteTask(PDO $dbCo)
// {
//     if (isset($_GET)) {
//         $queryDeleteTaskStatus = $dbCo->prepare("DELETE FROM task WHERE id_task = :id;");
//         $taskDelete = $queryDeleteTaskStatus->fetchAll();

//         $bindValues = [
//             'id' => htmlspecialchars($_GET['id']),
//         ];

//         $isUpdatetOk = $queryDeleteTaskStatus->execute($bindValues);
//     }
//     return $taskDelete;
// }