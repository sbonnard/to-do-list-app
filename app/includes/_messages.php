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
        // var_dump($_SESSION['msg']);
    }
}


$messages = [
    'insert_ok' => 'Tâche ajoutée.',
    'update_ok' => 'Tâche modifiée.',
    'delete_ok' => 'Tâche supprimée'
];

$errors = [
    'csrf' => 'Votre session est invalide.',
    'referer' => 'D\'où venez vous ?',
    'insert_ko' => 'Erreur lors de la création d\'une tâche.',
    'update_ko' => 'Erreur lors de la modif d\'une tâche.',
    'delete_ko' => 'Erreur lors de la suppression d\'une tâche.'
];

/**
 * Get error messages if the user fails to add a task.
 *
 * @return string The error message.
 */
function getErrorMessage(array $errors) :string
{
    if (isset($_SESSION['error'])) {
        $e = ($_SESSION['error']);
        unset($_SESSION['error']);
        return '<p class="notif notif--error">' . $errors[$e] . '</p>';
    }
    return '';
}

/**
 * Get success messages if the user succeeds to add a task.
 *
 * @return string The success message.
 */
function getSuccessMessage(array $messages) :string
{
    if (isset($_SESSION['msg'])) {
        $m = ($_SESSION['msg']);
        unset($_SESSION['msg']);
        return '<p class="notif notif--success">' . $messages[$m] . '</p>';
    }
    return '';
}
