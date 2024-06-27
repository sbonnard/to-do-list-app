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
} else if ($_REQUEST['action'] === 'modify' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    modifyTask($dbCo);
}


redirectTo('index.php');