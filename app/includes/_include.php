<?php

include_once "_functions.php";

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