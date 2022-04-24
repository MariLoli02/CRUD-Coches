<?php

    if(!isset($_GET['id'])){
        header("Location:index.php");
    }

    session_start();

    require dirname(__DIR__, 2)."/vendor/autoload.php";

    use App\Marcas;

    $id = $_GET['id'];

    $marcas = (new Marcas)->read($id);


    $hayError = false;

    function comprobar($val, $nombre, $cant){
        global $hayError;
        if(strlen($val)<$cant){
            $_SESSION[$nombre]="Error, el nombre debe tener $cant caracteres";
            $hayError = true;
        }
    }

    if(isset($_POST['btnActualizar'])){
        $nombre = trim($_POST['nombre']);
        $pais = trim($_POST['pais']);

        comprobar($nombre, 'nombre', 3);
        comprobar($pais, 'pais', 3);


        if((new Marcas)->existeNombre($nombre, $id)){
            $hayError = true;
            $_SESSION['nombre']="*** Error el libro ya existe, introduce otro distinto";
        }

        if(!$hayError){
            (new Marcas)->setNombre($nombre)
            ->setPais($pais)
            ->update($id);

            $_SESSION['info']="Marca Actualizada con Éxito";
            header("Location:index.php");
        }else{
            header("Location:update.php?id=$id");
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

    <title>Gestion Peliculas</title>
</head>
<body style="background-color: darkseagreen;">
    <h3 class="text-center mt-2">Actualizar Marca</h3>
    <div class="container">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=$id"; ?>" name="actualizar">
            <div class="form-group mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value ="<?php echo $marcas->nombre ?>">
                <?php
                    if(isset($_SESSION['nombre'])){
                        echo "<p class='text-danger mt-2'>{$_SESSION['nombre']}</p>";
                        unset($_SESSION['nombre']);
                    }
                
                ?>
            </div>

            <div class="form-group mb-3">
                <label for="pais" class="form-label">Pais: </label>
                <input type="text" class="form-control" name="pais" value="<?php echo $marcas->pais ?>">
                <?php
                    if(isset($_SESSION['pais'])){
                        echo "<p class='text-danger mt-2'>{$_SESSION['pais']}</p>";
                        unset($_SESSION['pais']);
                    }
                    
                ?>
            </div>

            <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
            <button type="submit" name="btnActualizar" class="btn btn-success"><i class="fas fa-save"></i> Actualizar</button>  
        </form>
    </div>
</body>
</html>
<?php } ?>