<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/Task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);

$stmt = $task->read();
$num = $stmt->rowCount();

if ($num>0) {
    $task_arr=array();
    $task_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $task_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "tag_id" => $tag_id,
            "tag_name" => $tag_name
        );
        array_push($task_arr["records"], $task_item);
    }
    http_response_code(200);
    echo json_encode($task_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Задачи не найдены."), JSON_UNESCAPED_UNICODE);
}