<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Autos;
use App\Marcas;

$datosM = (new Marcas)->readAll();
$hayError = false;

function comprobar($valor, $nombre, $cant){
    global $hayError;
    if(strlen($valor)<$cant){
        $_SESSION[$nombre]="Error, el campo $nombre debe tener como mínimo $cant de caracteres";
        $hayError= true;
    }
}

if(isset($_POST['btnEnviar'])){

    $modelo = trim($_POST['modelo']);
    $matricula = trim($_POST['matricula']);
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca_id'];

    comprobar($modelo, 'modelo', 3);
    comprobar($matricula, 'matricula', 7);

    if((new Autos)->existeMatricula($matricula)){
        $hayError = true;
        $_SESSION['matricula']= "Error, esa matricula ya existe";
    }

    if(!$hayError){
        (new Autos)->setModelo($modelo)
        ->setMatricula($matricula)
        ->setTipo($tipo)
        ->setMarca_id($marca)
        ->create();

        $_SESSION['info']="Auto Creado con Éxito";
        header("Location:index.php");
    }else{
        header("Location:crear.php");
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

    <title>Gestion Autos</title>
</head>

<body style="background-color:seagreen;">
    <h3 class="text-center mt-2 mb-4">Añadir Auto</h3>
    <div class="container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="crear">
            <div class="form-group mb-3">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" class="form-control" name="modelo">
                <?php
                    if(isset($_SESSION['modelo'])){
                        echo "<p class='text-danger'>{$_SESSION['modelo']}</p>";
                    } 
                    unset($_SESSION['modelo']);
                ?>
            </div>

            <div class="form-group mb-3">
                <label for="matricula" class="form-label">Matrícula:</label>
                <input type="text" class="form-control" name="matricula">
                <?php
                    if(isset($_SESSION['matricula'])){
                        echo "<p class='text-danger'>{$_SESSION['matricula']}</p>";
                    } 
                    unset($_SESSION['matricula']);
                ?>
            </div>
            
            <div class="from-group mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
                <select name="tipo" class="form-select">
                    <option value="Diesel">Diesel</option>
                    <option value="Gasolina">Gasolina</option>
                    <option value="Híbrido">Híbrido</option>
                    <option value="Eléctrico">Eléctrico</option>
                    <option value="Gas">Gas</option>
                </select>
            </div>

            <div class="from-group mb-3">
            <label for="marca_id" class="form-label">Marca:</label>
                <select name="marca_id" class="form-select">
                    <?php 
                        foreach($datosM as $item){
                            ECHO <<< TXT
                            <option value="{$item->id}">{$item->nombre}</option>
                            TXT;
                        }
                    ?>
                </select>
            </div>

            <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
            <button type="submit" name="btnEnviar" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
        </form>
    </div>

</body>

</html>
<?php } ?>