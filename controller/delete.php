<?php
include 'controller.php';

$id = isset($_GET["id"]) ? $_GET["id"] : "";

$global =  $controller->DeleteTask($id);
if ($global->status == 200) {
    header("Location:../index.php");
} else {
    header("Location:../index.php?error=".$global->message);
}
