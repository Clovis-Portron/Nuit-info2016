<?php
header("Access-Control-Allow-Origin: *");
session_start();

require_once("functions.php");
$pdo = getConnection();

$userId = $_GET["userId"];

$sql = "SELECT username,mail,priority,date_creation,id_user FROM User where id=:userId";
$query = $pdo->prepare($sql);
$query->bindValue (':userId', $userId);

$row = $query->query()->fetch();

$result = array(
"code" => "",
"content" => "");

if (empty($row)) {
    $result["code"] = 500;
    $result["content"] = "Error while retrieving user";
    echo json_encode($result);
    exit(1);
}

$result["code"] = 200;
$result["content"] = array(
    "id_user" => $row->id_user, 
    "username" => $row->username,
    "mail" => $row->mail,
    "date_creation" => $row->date,
    "priority" => $row->priority
);

echo json_encode($result);