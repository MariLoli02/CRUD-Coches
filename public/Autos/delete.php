<?php

use App\Autos;

    if(!$_GET['id']){
        header("Location:index.php");
    }
    session_start();
    require dirname(__DIR__,2)."/vendor/autoload.php";

    (new Autos)->delete($_GET['id']);
    
    $_SESSION['info']= "Auto Eliminado con Éxito";
    header("Location:index.php");

