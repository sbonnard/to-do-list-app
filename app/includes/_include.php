<?php

include_once "_functions.php";

// CREATE NEW TASKS 
if (!empty($_POST)) {

    preventFromCSRF();

    $errors = [];



    if (
        isset($_POST['name'])
        && strlen($_POST['name']) > 0
        && strlen($_POST['name']) < 50
        && isset($_POST['emergency_level'])
        && is_numeric($_POST['emergency_level'])
        && $_POST['emergency_level'] > 0
        && $_POST['emergency_level'] <= 5
    ) {
        $insert = $dbCo->prepare("INSERT INTO task (`name`, `date`, `emergency_level`) VALUES (:name, CURDATE(), :emergency_level);");

        $bindValues = [
            'name' => htmlspecialchars($_POST['name']),
            'emergency_level' => round($_POST['emergency_level'])
        ];

        $isInsertOk = $insert->execute($bindValues);

        $nb = $insert->rowCount();

        $newRefProduct = $dbCo->lastInsertId();

        // var_dump($isInsertOk, $nb, $newRefProduct);
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