<?php
session_start();

include 'includes/_config.php';
include 'includes/_functions.php';
include 'includes/_database.php';
include 'includes/_messages.php';

header('Content-type:application/json');

$inputData = json_decode(file_get_contents('php://input'), true);


if (!isset($inputData['action'])) {
    triggerError('no_action');
}

// Check CSRF
preventFromCSRFAPI($inputData);

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && $inputData['action'] === 'end_task' && isset($inputData['id']) && is_numeric($inputData['id'])) {
   if(endTask($dbCo, $inputData)){
       $response = [
           'isOk' => true,
           'id' => intval($inputData['id'])
       ];
    
       echo json_encode($response);
   }

}


if ($_SERVER['REQUEST_METHOD'] === 'PUT' && $inputData['action'] === 'redo_task' && isset($inputData['id']) && is_numeric($inputData['id'])) {
   if(redoTask($dbCo, $inputData)){
       $response = [
           'isOk' => true,
           'id' => intval($inputData['id'])
       ];
    
       echo json_encode($response);
   }

}


if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $inputData['action'] === 'delete' && isset($inputData['id']) && is_numeric($inputData['id'])) {
    if(deleteTask($dbCo, $inputData)){
        $response = [
            'isOk' => true,
            'id' => intval($inputData['id'])
        ];
     
        echo json_encode($response);
    }
 
 }