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
 * Get the form to add tasks if "if()" boolean is true.
 *
 * @param array $arrayGet The array that must be empty.
 * @param array $arraySession The array to secure the session from CSRF containing the token.
 * @return void
 */
function getAddTaskForm(array $arrayGet, array $arraySession)
{
    if (empty($arrayGet)) {
        return '<form class="form" action="actions.php" method="post" aria-label="Formulaire d\'ajout de tâches">
        <label class="form__label" for="task">Ajouter une tâche</label>
        <input class="form__input" name="name" type="text" placeholder="Faire un truc" required>
        <label class="form__label" for="emergency_level">Niveau d\'urgence</label>
        <input class="form__input" name="emergency_level" type="text" placeholder="111">
        <input class="form__submit" type="submit" value="">
        <input type="hidden" name="token" value="' . $arraySession['token'] . '">
        <input type="hidden" name="action" value="create">
    </form>';
    }
}

/**
 * Displays wether a link to add a deadline, wether a deadline.
 *
 * @param array $task The array you want the deadline date from.
 * @return void
 */
function displayIfDeadline(array $task)
{
    if ($task['deadline'] != NULL) {
        return '<div class="task-content task-content--deadline"><p>Deadline: <a class="deadline" href="?action=deadline&id=' . $task['id_task'] . '">' . date("d-m-Y", strtotime($task['deadline'])) . ' 📆</a></p></div>';
    } else {
        return '<div class="task-content task-content--deadline"><p>Deadline: <a class="deadline" href="?action=deadline&id=' . $task['id_task'] . '">Ajouter une deadline 📆</a></p></div>';
    }
}

/**
 * Get a form to change deadline when clicking on the deadline link.
 *
 * @param array $array The $_GET array.
 * @return void
 */
function setDeadlineForm(array $array)
{
    if (!empty($array) && isset($array['action']) && $array['action'] === 'deadline' && is_numeric($array['id'])) {
        return
            '<form class="form" action="actions.php" method="post" aria-label="Formulaire pour définir une deadline">
    <label class="form__label" for="date" required>Définir une deadline pour la tâche n° <span class="task__number">' . $array['id'] . '</span></label>
    <input class="form__input" type="date" name="date" id="date" aria-label="Choisis une deadline dans le calendrier">
    <input class="form__submit" type="submit" value="">

    <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
    <input type="hidden" name="action" value="deadline">
    <input type="hidden" name="id" value="' . $array['id'] . '">
    </form>';
    }
}


function updateOrSetDeadline(PDO $dbCo)
{

    $errors = [];

    if (!isset($_REQUEST['date']) || empty($_REQUEST['date'])) {
        $errors[] = '<p class="error">Merci d\'entrer une date.</p>';
    }

    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
        $errors[] = '<p class="error">ID de la tâche non valide.</p>';
    }
    // var_dump($errors);

    if (empty($errors)) {
        $setDeadline = $dbCo->prepare("UPDATE task SET deadline = :deadline WHERE id_task = :id;");

        $bindValues = [
            'deadline' => date("Y-m-d", strtotime($_REQUEST['date'])),
            'id' => intval($_REQUEST['id'])
        ];

        $isDeadlineOk = $setDeadline->execute($bindValues);

        if ($isDeadlineOk) {
            $_SESSION['msg'] = "deadline_ok";
        } else {
            $_SESSION['msg'] = "deadline_ko";
        }
        return $isDeadlineOk;
    }
}

/**
 * Changes sentence if themes are defined
 *
 * @param array $tasks The main array 
 * @param array $task A single task in main array to loop on?
 * @return void
 */
function displayIfThemeSet(array $tasks, array $task) {
    $themesSentence = ' :';
    if ($task['id_task'] != 0) {
        foreach($tasks as $task) {
            $themesSentence .= $task['theme_name'] . ' | ';
        }
        return $themesSentence;
}
}

function getAddThemeForm(array $arrayGet, array $arraySession) {
    if(!empty($_GET) && isset($_GET['action']) && $_GET['action'] === 'set-theme' && is_numeric($_GET['id'])) {
        return 
        '<form class="form" action="actions.php" method="post" aria-label="Formulaire pour définir un thème à une tâche.">
        <label class="form__label" for="theme" required>Définir un thème pour la tâche n° <span class="task__number">' . $arrayGet['id'] . '</span></label>
        <input class="form__input" type="select" name="theme" id="theme" aria-label="Choisis un thème à ajouter à une tâche">'
        // Créer une boucle foreach pour générer toutes les options depuis la base de données.
        .'<option value=""></option>
        </select>' .
        // -----------------------------------------------------
        '<input class="form__submit" type="submit" value="">

        <input type="hidden" name="token" value="' . $arraySession['token'] . '">
        <input type="hidden" name="action" value="deadline">
        <input type="hidden" name="id" value="' . $arrayGet['id'] . '">
        </form>';
    }
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
    $today = date('Y-m-d');
    $notification = false; 
    
    foreach ($taskarray as $task) {
        // var_dump($task['id_task']);
        $allTasks .=  '<li class="task">'
            . '<div class="task__content"><p class="task__number-symbol">N°<span class="task__number">'
            . $task["id_task"]
            . '</span><h3 class="ttl ttl--small">'
            . $task['name'] . '</h3></div>'
            . '<div class="task__content"><a class="lnk--theme" href="?action=set-theme&id='
            . $task['id_task'].
            '"></a></div>'
            . '<div class="task__content task__content--date-and-level"><p>'
            . $task['date']
            . '</p>'
            . '<p>Niveau <span class="task__number">'
            . $task['emergency_level']
            . '</span></p></div>'
            . displayIfDeadline($task)
            . '<a href="?action=end_task&id='
            . $task['id_task']
            . '" class="btn">C’est fait !</a></li>';

            if ($task['deadline'] === $today) {
                $notification = true;
            }
    }

    if ($notification === true) {
        $_SESSION['notifs'] = "deadline_urgent";
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
            . $task['name'] . '</h3><span class="check">✔</span></div>'
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

        if ($_POST['emergency_level'] > 255) {
            $errors[] = '<p class="error">La valeur de priorité doit être comprise entre 1 & 255.</p>;';
        }

        // var_dump($errors);

        if (empty($errors)) {
            $insert = $dbCo->prepare("INSERT INTO task (`name`, `date`, `emergency_level`) VALUES (:name, CURDATE(), :emergency_level);");

            $bindValues = [
                'name' => htmlspecialchars($_POST['name']),
                'emergency_level' => round($_POST['emergency_level'])
            ];

            $isInsertOk = $insert->execute($bindValues);

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

        if (!empty($errors)) {
            return implode("\n", $errors);
        }

        $update = $dbCo->prepare(
            "UPDATE task SET `name` = :name, `date` = CURDATE() WHERE id_task = :id;"
        );

        $bindValues = [
            'id' => htmlspecialchars($_POST['numbertask']),
            'name' => htmlspecialchars($_POST['newname']),
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

/**
 * Modifies task's priority level to reorder the to do list.
 *
 * @param PDO $dbCo
 * @return void
 */
function modifyTaskPriority(PDO $dbCo)
{
    if (!empty($_POST)) {
        preventFromCSRF('index.php');

        $errors = [];

        if (!isset($_POST['numbertask_emergency']) || strlen($_POST['numbertask_emergency']) <= 0) {
            $errors[] = '<p class="error">Merci d\'entrer un numéro de tâche.</p>';
        }

        if (!isset($_POST['new_emergency_level'])) {
            $errors[] = '<p class="error">Merci d\'entrer un niveau de priorité.</p>';
        }

        if (!is_numeric($_POST['new_emergency_level'])) {
            $errors[] = '<p class="error">La valeur de priorité doit être numérique.</p>';
        }

        if ($_POST['new_emergency_level'] <= 0 || $_POST['new_emergency_level'] > 255) {
            $errors[] = '<p class="error">La valeur de priorité doit être comprise entre 1 et 255.</p>';
        }

        if (!empty($errors)) {
            return implode("\n", $errors);
        }

        $update = $dbCo->prepare(
            "UPDATE task SET `emergency_level` = :emergency_level WHERE id_task = :id;"
        );

        $bindValues = [
            'id' => intval($_POST['numbertask_emergency']),
            'emergency_level' => round($_POST['new_emergency_level'])
        ];

        $isUpdateOk = $update->execute($bindValues);

        if ($isUpdateOk) {
            $_SESSION['msg'] = "update_emergency_ok";
        } else {
            $_SESSION['msg'] = "update_emergency_ko";
        }

        return $isUpdateOk;
    }
}

/**
 * Deletes a task from To Do List.
 *
 * @param   $dbCo
 * @return void
 */
function deleteTask(PDO $dbCo)
{
    if (!empty($_REQUEST)) {
        preventFromCSRF('index.php');

        $errors = [];

        if (!isset($_REQUEST['numbertask_delete']) || strlen($_REQUEST['numbertask_delete']) <= 0) {
            $errors[] = '<p class="error">Merci d\'entrer un numéro de tâche.</p>';
        }

        if (!empty($errors)) {
            return implode("\n", $errors);
        }

        $delete = $dbCo->prepare(
            "DELETE FROM task WHERE id_task = :id;"
        );

        $bindValues = [
            'id' => htmlspecialchars($_REQUEST['numbertask_delete']),
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

/**
 * Creates a new theme to database that can be used to thematize a task.
 *
 * @param PDO $dbCo The connection to database
 * @param array $arrayPost The array you get your datas from
 * @return void
 */
function createNewTheme(PDO $dbCo, array $arrayPost)
{
    if (!empty($arrayPost)) {

        $errors = [];

        if (!isset($arrayPost['new-theme']) || strlen($arrayPost['new-theme']) <= 0) {
            $errors[] = '<p class="error">Merci d\'entrer un nom de thème.</p>';
        }

        if (strlen($arrayPost['new-theme']) > 50) {
            $errors[] = '<p class="error">Merci d\'entrer un nom de tâche de 50 caractères maximum.</p>';
        }

        if (empty($errors)) {
            $insert = $dbCo->prepare("INSERT INTO themes (`theme_name`) VALUES (:name);");

            $bindValues = [
                'name' => htmlspecialchars($arrayPost['new-theme'])
            ];

            $isInsertOk = $insert->execute($bindValues);

            if ($isInsertOk) {
                $_SESSION['msg'] = "insert_theme_ok";
            } else {
                $_SESSION['msg'] = "insert_theme_ko";
            }
            return $isInsertOk;
        }
    }
}