<?php
include 'controller.php';

$id = isset($_POST["id"]) ? $_POST["id"] : "";
$name = isset($_POST["name"]) ? $_POST["name"] : "";

$global =  $controller->CreateTask($id,$name);
if ($global->status == 200) {
    header("Location:../index.php");
} else {
    header("Location:../index.php?error=".$global->message);
}
