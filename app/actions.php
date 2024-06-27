<?php
require_once './includes/_database.php';
require_once './includes/_functions.php';


// // /**
// //  * Create a new task from the infos put in the form.
// //  *
// //  * @param [type] $dbCo The connection to database
// //  * @return void 
// //  */
// createNewTask($dbCo);

// modifyTask($dbCo);


// // Contrôle d'exécution des fonctions en fonction de la clé dans $_POST
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['action']) && $_POST['action'] === 'create') {
//         echo createNewTask($dbCo);
//     } elseif (isset($_POST['action']) && $_POST['action'] === 'modify') {
//         echo modifyTask($dbCo);
//     }
// }

redirectTo('index.php');