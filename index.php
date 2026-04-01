<?php

require_once "components/session.php";

if(isset($_SESSION["user"])){
    header("Location: dashboard.php");
}else{
    header("Location: login.php");
}