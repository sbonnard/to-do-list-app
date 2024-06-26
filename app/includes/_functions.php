<?php
// PREVENT FROM CSRF 

/**
 * Generates a random token for forms to prevent from CSRF.
 *
 * @return void
 */
function generateToken()
{
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    }
}

/**
 * Prevents from CSRF by checking HTTP_REFERER in $_SERVER and checks if the random token from generateToken() matches in form.
 *
 * @return void
 */
function preventFromCSRF() {
    if (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], 'http://localhost:8282')) {
        $_SESSION['error'] = "Erreur de HTTP_REFERER";
        header('Location: index.php');
        exit;
    }

    if (!isset($_SESSION['token']) || !isset($_POST['token']) || $_SESSION['token'] !== $_POST['token']) {
        $_SESSION['error'] = "ERREUR CSRF";
        header('Location: index.php');
        exit;
    }
}

/**
 * Generates content directly from the database.
 *
 * @param array $taskarray The table from database you want to get the informations from.
 * @return string A string with HTML elements to create content in a webpage.
 */
function generateTask(array $taskarray) :string
{
    $allTasks = '';
    foreach ($taskarray as $task) {
        // var_dump($task['id_task']);
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

// ----------------------------------------------------------------------------------------

/**
 * Switches a task to done and delete it from the DOM but not from databse.
 *
 * @param PDO $dbCo The connection to database
 * @return void 
 */
function endTask(PDO $dbCo)
{
    $queryUpdateTaskStatus = $dbCo->prepare("UPDATE task SET status = 'DONE' WHERE id_task = :id;");

    $taskUpdate = $queryUpdateTaskStatus->fetchAll();

    $bindValues = [
        'id' => htmlspecialchars($_GET['id']),
    ];

    $isUpdatetOk = $queryUpdateTaskStatus->execute($bindValues);
    return $taskUpdate;
}