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
function preventFromCSRF(string $redirectURL = 'index.php')
{
    global $globalURL;
    if (!isset($_SERVER['HTTP_REFERER']) || !str_contains($_SERVER['HTTP_REFERER'], $globalURL)) {
        $_SESSION['error'] = "referer";
        redirectTo($redirectURL);
    }

    if (!isset($_SESSION['token']) || !isset($_REQUEST['token']) || $_SESSION['token'] !== $_REQUEST['token']) {
        $_SESSION['error'] = 'csrf';
        redirectTo($redirectURL);
    }
}

/**
 * Redirect to the given URL.
 *
 * @param string $url
 * @return void
 */
function redirectTo(string $url): void
{
    // var_dump('REDIRECT ' . $url);
    header('Location: ' . $url);
    exit;
}

/**
 * Generates content directly from the database for tasks that are already done.
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
            . '<div class="task__content"><p class="task__number-symbol">N°<span class="task__number">'
            . $task["id_task"]
            . '</span><h3 class="ttl ttl--small">'
            . $task['name'] . '</h3></div>'
            . '<div class="task__content task__content--date-and-level"><p>'
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

/**
 * Generates content directly from the database.
 *
 * @param array $taskarray The table from database you want to get the informations from.
 * @return string A string with HTML elements to create content in a webpage.
 */
function generateDoneTask(array $taskarray): string
{
    $allTasks = '';
    foreach ($taskarray as $task) {
        // var_dump($task['id_task']);
        $allTasks .=  '<li class="task">'
            . '<div class="task__content"><p class="task__number-symbol">N°<span class="task__number">'
            . $task["id_task"]
            . '</span><h3 class="ttl ttl--small">'
            . $task['name'] . '</h3></div>'
            . '<div class="task__content task__content--date-and-level"><p>'
            . $task['date']
            . '</p>'
            . '<p>Niveau <span class="task__number">'
            . $task['emergency_level']
            . '</span></p></div><a href="?id='
            . $task['id_task']
            . '" class="btn">À refaire !</a></li>';
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

    redirectTo('index.php');

    return $taskUpdate;
}

/**
 * Switches a task to done and delete it from the DOM but not from databse.
 *
 * @param PDO $dbCo The connection to database
 * @return void Erase a task from to do list.
 */
function redoTask(PDO $dbCo)
{
    $queryUpdateTaskStatus = $dbCo->prepare("UPDATE task SET status = 'TO DO' WHERE id_task = :id;");

    $taskUpdate = $queryUpdateTaskStatus->fetchAll();

    $bindValues = [
        'id' => htmlspecialchars($_GET['id']),
    ];

    $isUpdatetOk = $queryUpdateTaskStatus->execute($bindValues);

    redirectTo('done.php');

    return $taskUpdate;
}

// ----------------------------------------------------------------------------------------


/**
 * Create a new task from the infos put in the form.
 *
 * @param [type] $dbCo The connection to database
 * @return void 
 */
function createNewTask(PDO $dbCo)
{
    if (!empty($_POST)) {

        preventFromCSRF('index.php');

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
            if ($isInsertOk) {
                $_SESSION['msg'] = "insert_ok";
            } else {
                $_SESSION['msg'] = "insert_ko";
            }
            return $isInsertOk;
        }
    }
}

/**
 * Modifiers a task thanks toi it's ID as numlber task in UX.
 *
 * @param [type] $dbCo
 * @return void
 */
function modifyTask(PDO $dbCo)
{
    if (!empty($_POST)) {
        preventFromCSRF('index.php');

        $errors = [];

        if (!isset($_POST['numbertask']) || strlen($_POST['numbertask']) <= 0) {
            $errors[] = '<p class="error">Merci d\'entrer un numéro de tâche.</p>';
        }

        if (!isset($_POST['newname']) || strlen($_POST['newname']) <= 0) {
            $errors[] = '<p class="error">Merci d\'entrer un nouveau nom de tâche.</p>';
        }

        if (strlen($_POST['newname']) > 50) {
            $errors[] = '<p class="error">Merci d\'entrer un nom de tâche de 50 caractères maximum.</p>';
        }

        if (!isset($_POST['new_emergency_level'])) {
            $errors[] = '<p class="error">Merci d\'entrer un niveau de priorité.</p>';
        }

        if (!is_numeric($_POST['new_emergency_level'])) {
            $errors[] = '<p class="error">La valeur de priorité doit être numérique.</p>';
        }

        if ($_POST['new_emergency_level'] <= 0 || $_POST['new_emergency_level'] > 5) {
            $errors[] = '<p class="error">La valeur de priorité doit être comprise entre 1 et 5.</p>';
        }

        if (!empty($errors)) {
            return implode("\n", $errors);
        }

        $update = $dbCo->prepare(
            "UPDATE task SET `name` = :name, `date` = CURDATE(), `emergency_level` = :emergency_level WHERE id_task = :id;"
        );

        $bindValues = [
            'id' => htmlspecialchars($_POST['numbertask']),
            'name' => htmlspecialchars($_POST['newname']),
            'emergency_level' => round($_POST['new_emergency_level'])
        ];

        $isUpdateOk = $update->execute($bindValues);

        if ($isUpdateOk) {
            $_SESSION['msg'] = "update_ok";
        } else {
            $_SESSION['msg'] = "update_ko";
        }

        return $isUpdateOk;
    }
}

function deleteTask(PDO $dbCo)
{
    if (!empty($_POST)) {
        preventFromCSRF('index.php');

        $errors = [];

        if (!isset($_POST['numbertask_delete']) || strlen($_POST['numbertask_delete']) <= 0) {
            $errors[] = '<p class="error">Merci d\'entrer un numéro de tâche.</p>';
        }

        if (!empty($errors)) {
            return implode("\n", $errors);
        }

        $delete = $dbCo->prepare(
            "DELETE FROM task WHERE id_task = :id;"
        );

        $bindValues = [
            'id' => htmlspecialchars($_POST['numbertask_delete']),
        ];

        $isDeleteOk = $delete->execute($bindValues);

        if ($isDeleteOk) {
            $_SESSION['msg'] = "delete_ok";
        } else {
            $_SESSION['msg'] = "delete_ko";
        }

        return $isDeleteOk;
    }
}
