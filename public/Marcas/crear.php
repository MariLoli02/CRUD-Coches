<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Marcas;
$hayError = false;


function comprobar($valor, $nombre, $cant){
    global $hayError;
    if(strlen($valor)<$cant){
        $_SESSION[$nombre]= "*** Error, el campo $nombre debe tener como minimo $cant caracteres";
        $hayError = true;
    }
}


if(isset($_POST['btnEnviar'])){
    $nom = trim($_POST['nombre']);
    $pais = trim($_POST['pais']);

    comprobar($nom, 'nombre', 3);
    comprobar($pais, 'pais', 3);

    if((new Marcas)->existeNombre($nom)){
        header("Location:crear.php");
        $_SESSION['nombre']="*** Error el libro ya existe, introduce otro distinto";
        $hayError = true;
    }
    // comprueba si hay error
    if($hayError){
        header("Location:crear.php");
    }else{
        (new Marcas)->setNombre($nom)
        ->setPais($pais)
        ->create();

        $_SESSION['info'] ="Marca Creada con Éxito";

        header("Location:index.php");
    }


}else{
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CDN SWEETALERT2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Gestion Marcas</title>
</head>

<body style="background-color:seagreen;">
    <h3 class="text-center mt-2 mb-4">Añadir Marca</h3>
    <div class="container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="crear">
            <div class="form-group mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre">
                <?php
                    if(isset($_SESSION['nombre'])){
                        echo "<p class='text-danger mt-2'>{$_SESSION['nombre']}</p>";
                        unset($_SESSION['nombre']);
                    }
                
                ?>
            </div>

            <div class="form-group mb-3">
                <label for="pais" class="form-label">Pais: </label>
                <input type="text" class="form-control" name="pais">
                <?php
                    if(isset($_SESSION['pais'])){
                        echo "<p class='text-danger mt-2'>{$_SESSION['pais']}</p>";
                        unset($_SESSION['pais']);
                    }
                    
                ?>
            </div>

            <button type="reset" class="btn btn-danger"><i class="fas fa-brush"></i> Limpiar</button>
            <button type="submit" name="btnEnviar" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>  
        </form>
    </div>

</body>

</html>

<?php } ?>