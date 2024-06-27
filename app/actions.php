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

if($_REQUEST['action'] === 'create'){
    createNewTask($dbCo);
} elseif ($_REQUEST['action'] === 'modify') {
    modifyTask($dbCo);
}


redirectTo('index.php');