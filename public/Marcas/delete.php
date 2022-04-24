<?php 
    session_start();
    
    require dirname(__DIR__,2)."/vendor/autoload.php";

    use App\Marcas;

    if(isset($_GET['id'])){
        (new Marcas)->delete($_GET['id']);
        $_SESSION['info']="Libro Borrado con Éxito";
    }
    header("Location:index.php");