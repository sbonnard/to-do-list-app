<?php
session_start();

include 'includes/_config.php';
include 'includes/_functions.php';
include 'includes/_database.php';

header('Content-type:application/json');

if (!isset($_REQUEST['action'])) {
    var_dump('NO ACTION');
    exit;
}

if ($_REQUEST['action'] === 'end_task' && isset($_REQUEST['id']) && intval($_REQUEST['id'])) {
   if(endTask($dbCo)){
       $response = [
           'isOk' => true,
           'id' => intval($_REQUEST['id'])
       ];
    
       echo json_encode($response);
   }

}


if ($_REQUEST['action'] === 'redo_task' && isset($_REQUEST['id']) && intval($_REQUEST['id'])) {
   if(redoTask($dbCo)){
       $response = [
           'isOk' => true,
           'id' => intval($_REQUEST['id'])
       ];
    
       echo json_encode($response);
   }

}