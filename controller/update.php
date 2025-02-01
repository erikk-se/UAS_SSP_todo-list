<?php
include 'controller.php';

$id = isset($_GET["id"]) ? $_GET["id"] : "";
$status = isset($_GET["status"]) ? $_GET["status"] : "";

$global =  $controller->UpdateTask($id, $status);
if ($global->status == 200) {
    header("Location:../index.php");
} else {
    header("Location:../index.php?error=".$global->message);
}
