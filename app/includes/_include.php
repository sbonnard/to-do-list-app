<?php

include_once "_functions.php";

// CREATE NEW TASKS 
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



// GET TASKS FROM DATABASE 
// $queryGetTasks = $dbCo->query("SELECT id_task, status, name, date, emergency_level FROM task WHERE status = 'TO DO';");
// $tasks = $queryGetTasks->fetchAll();


// function deleteTask(PDO $dbCo)
// {
//     if (isset($_GET)) {
//         $queryDeleteTaskStatus = $dbCo->prepare("DELETE FROM task WHERE id_task = :id;");
//         $taskDelete = $queryDeleteTaskStatus->fetchAll();

//         $bindValues = [
//             'id' => htmlspecialchars($_GET['id']),
//         ];

//         $isUpdatetOk = $queryDeleteTaskStatus->execute($bindValues);
//     }
//     return $taskDelete;
// }