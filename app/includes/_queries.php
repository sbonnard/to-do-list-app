<?php

$queryGetTasks = $dbCo->query("SELECT id_task, status, name, date, emergency_level FROM task WHERE status = 'TO DO' ORDER BY emergency_level DESC;");
$tasks = $queryGetTasks->fetchAll();