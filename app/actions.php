<?php
session_start();

include 'includes/_config.php';
include 'includes/_functions.php';
include 'includes/_database.php';

if (!isset($_REQUEST['action'])) {
    redirectTo('index.php');
}

// CSRF
preventFromCSRF();

// if($_REQUEST['action'] === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST'){
//     createNewTask($dbCo);
// } else 

if ($_REQUEST['action'] === 'modify' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    modifyTask($dbCo);
} else if ($_REQUEST['action'] === 'modify_emergency' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    modifyTaskPriority($dbCo);
} else if ($_REQUEST['action'] === 'deadline' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    updateOrSetDeadline($dbCo);
} else if ($_REQUEST['action'] === 'new-theme' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    createNewTheme($dbCo, $_POST);
} else if ($_REQUEST['action'] === 'set-theme' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    addThemeToTask($dbCo);
}

redirectTo('index.php');