<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/Tag.php';

$database = new Database();
$db = $database->getConnection();

$tag = new Tag($db);

$stmt = $tag->read();
$num = $stmt->rowCount();

if ($num>0) {

    $tags_arr=array();
    $tags_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $tag_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
        );
        array_push($tags_arr["records"], $tag_item);
    }
    http_response_code(200);
    echo json_encode($tags_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Категории не найдены."), JSON_UNESCAPED_UNICODE);
}