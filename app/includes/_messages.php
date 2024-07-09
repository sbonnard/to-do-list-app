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
    'delete_ok' => 'Tâche supprimée.',
    'update_emergency_ok' => 'Niveau de priorité modifié.',
    'deadline_ok' => 'La deadline a bien été modifiée.',
    'insert_theme_ok' => 'Le nouveau thème a été créé.',
    'set_theme_ok' => 'Le thème a été ajouté à la tâche'
];

$errors = [
    'csrf' => 'Votre session est invalide.',
    'referer' => 'D\'où venez vous ?',
    'insert_ko' => 'Erreur lors de la création d\'une tâche.',
    'update_ko' => 'Erreur lors de la modif d\'une tâche.',
    'delete_ko' => 'Erreur lors de la suppression d\'une tâche.',
    'update_emergency_ko' => 'Erreur lors de la modif du niveau de priorité.',
    'deadline_ko' => 'Erreur lors de la modif de la deadline.',
    'no_action' => 'Aucune action détectée.',
    'insert_theme_ko' => 'Erreur lors de la création d\'un nouveau thème.',
    'set_theme_ko' => 'Erreur lors de l\'ajout du thème à la tâche.',
    'set_theme_ko_empty' => 'Merci de sélectionner un thème existant'
];

$notifs = [
    'deadline_urgent' => '📢 Attention ! Une ou plusieurs tâches sont à effectuer aujourd\'hui !'
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

function getNotif(array $notifs) :string
{
    if (isset($_SESSION['notifs'])) {
        $n = ($_SESSION['notifs']);
        unset($_SESSION['notifs']);
        return '<p class="notif notif--error notif--error--big">' . $notifs[$n] . '</p>';
    }
    return '';
}
