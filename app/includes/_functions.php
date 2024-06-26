<?php
// PREVENT FROM CSRF 

/**
 * Generates a random token for forms to prevent from CSRF. It also generate a new token after 15 minutes.
 *
 * @return void
 */
function generateToken()
{
    if (
        !isset($_SESSION['token'])
        || !isset($_SESSION['tokenExpire'])
        || $_SESSION['tokenExpire'] < time()
    ) {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        $_SESSION['tokenExpire'] = time() + 60 * 15;
    }
}

/**
 * Prevents from CSRF by checking HTTP_REFERER in $_SERVER and checks if the random token from generateToken() matches in form.
 *
 * @return void
 */
function preventFromCSRF()
{
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
function generateTask(array $taskarray): string
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
 * @return void Erase a task from to do list.
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

// ----------------------------------------------------------------------------------------


/**
 * Create a new task from the infos put in the form.
 *
 * @param [type] $dbCo The connection to database
 * @return void 
 */
function createNewTask($dbCo)
{
    if (!empty($_POST)) {

        preventFromCSRF();

        $errors = [];

        if (!isset($_POST['name']) || strlen($_POST['name']) <= 0) {
            $errors[] = '<p class="error">Merci d\'entrer un nom de tâche.</p>';
        }

        if (strlen($_POST['name']) > 50) {
            $errors[] = '<p class="error">Merci d\'entrer un nom de tâche de 50 caractères maximum.</p>';
        }

        if (!isset($_POST['emergency_level'])) {
            $errors[] = '<p class="error">Merci d\'entrer un niveau de priorité.</p>';
        }

        if (!is_numeric($_POST['emergency_level'])) {
            $errors[] = '<p class="error">La valeur de priorité doit être numérique.</p>;';
        }

        if ($_POST['emergency_level'] <= 0) {
            $errors[] = '<p class="error">La valeur de priorité doit être comprise entre 1 & 5.</p>;';
        }

        if ($_POST['emergency_level'] > 5) {
            $errors[] = '<p class="error">La valeur de priorité doit être comprise entre 1 & 5.</p>;';
        }

        // var_dump($errors);

        if (empty($errors)) {
            $insert = $dbCo->prepare("INSERT INTO task (`name`, `date`, `emergency_level`) VALUES (:name, CURDATE(), :emergency_level);");

            $bindValues = [
                'name' => htmlspecialchars($_POST['name']),
                'emergency_level' => round($_POST['emergency_level'])
            ];

            $isInsertOk = $insert->execute($bindValues);

            $nb = $insert->rowCount();

            $newRefProduct = $dbCo->lastInsertId();

            // var_dump($isInsertOk, $nb, $newRefProduct);

            return $isInsertOk;
        }
    }
}