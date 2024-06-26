<?php

/**
 * Get a message, error or success whenever the user is trying to add a new task.
 *
 * @param [type] $dbCo The connection to database.
 * @return void
 */
function getMessageForNewTask($dbCo)
{
    if (createNewTask($dbCo)) {
        $_SESSION['msg'] = "insert_ok";
        header('Location: index.php');
        exit;
    }
}

$errors = [
    'csrf' => 'Votre session est invalide.',
    'referer' => 'D\'où venez vous ?',
    'insert_ko' => 'Erreur lors de la création d\'une tâche.',
    'update_ko' => 'Erreur lors de la modif d\'une tâche.'
];

$messages = [
    'insert_ok' => 'Tâche ajoutée.',
    'update_ok' => 'Tâche modifiée.'
];

/**
 * Get error messages if the user fails to add a task.
 *
 * @param array $errors The array containing error messages.
 * @return void
 */
function getErrorMessage(array $errors)
{
    if (isset($_SESSION['error'])) {
        echo '<p class="notif notif--error">' . $errors[$_SESSION['error']] . '</p>';
        unset($_SESSION['error']);
    }
}

/**
 * Get success messages if the user succeeds to add a task.
 *
 * @param array $errors The array containing success messages.
 * @return void
 */
function getSuccessMessage(array $messages)
{
    if (isset($_SESSION['msg'])) {
        echo '<p class="notif notif--success">' . $messages[$_SESSION['msg']] . '</p>';
        unset($_SESSION['msg']);
    }
}
