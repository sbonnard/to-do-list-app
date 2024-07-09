<?php
session_start();

include 'includes/_config.php';
include 'includes/_functions.php';
include 'includes/_database.php';
include 'includes/_messages.php';

// header('Content-type:application/json');

$inputData = json_decode(file_get_contents('php://input'), true);


if (!isset($inputData['action'])) {
    triggerError('no_action');
}

// Check CSRF
preventFromCSRFAPI($inputData);

// if ($_REQUEST['action'] === 'end_task' && isset($_REQUEST['id']) && intval($_REQUEST['id'])) {
//    if(endTask($dbCo)){
//        $response = [
//            'isOk' => true,
//            'id' => intval($_REQUEST['id'])
//        ];
    
//        echo json_encode($response);
//    }

// }


// if ($_REQUEST['action'] === 'redo_task' && isset($_REQUEST['id']) && intval($_REQUEST['id'])) {
//    if(redoTask($dbCo)){
//        $response = [
//            'isOk' => true,
//            'id' => intval($_REQUEST['id'])
//        ];
    
//        echo json_encode($response);
//    }

// }


if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $inputData['action'] === 'delete' && isset($inputData['id']) && is_numeric($inputData['id'])) {
    if(deleteTask($dbCo, $inputData)){
        $response = [
            'isOk' => true,
            'id' => intval($inputData['id'])
        ];
     
        echo json_encode($response);
    }
 
 }