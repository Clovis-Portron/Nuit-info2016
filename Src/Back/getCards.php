<?php 

session_start();

require_once("functions.php");
$pdo = getConnection();

$startId = $_POST["startId"];
$length = $_POST["length"];

$sql = "select * from Card where id>=:startId and id<:startId+:length";

$query = $pdo->prepare($sql);
$query->bindValue (':startId', $startId);
$query->bindValue(":length", $length);

$ret = $query->execute();

$result = array(
    "code" => "",
    "content" => "");

while ($row = $query->fetch()) {
    $cards[] = array(
        "id_card" => $row->id_card,
        "description" => $row->description,
        "title" => $row->title,
        "date" => $row->date,
        "priority" => $row->priority
    );
}

$result["code"] = 200;
$result["content"] = $cards;

echo json_encode($result);
