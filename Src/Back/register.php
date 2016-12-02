<?php 
session_start();

require_once("functions.php");
$pdo = getConnection();

$username = $_POST["username"];
$password = $_POST["pwd"];
$mail = $_POST["mail"];
$priority = "IMPORTANT";

$sql = "insert into User(username,pwd,mail,priority,date_creation) values(:username,:password, :mail, :priority , NOW())";
$query = $pdo->prepare($sql);
$query->bindValue (':username', $username);
$query->bindValue(":password", $password);
$query->bindValue(":mail", $mail);

$ret = $query->execute();

$result = array(
    "code" => "",
    "content" => "");

if ($ret != 0) {
    $result["code"] = 500;
    $result["content"] = "Error while registering the user";
    echo json_encode($result);
    exit(1);
}

$idUser = $query->lastInsertId();

$result["code"] = 200;
$result["content"] = $idUser;

echo json_encode($result);
