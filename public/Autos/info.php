<?php
    if(!$_GET['id']){
        header("Location:index.php");
    }

    session_start();
    require dirname(__DIR__, 2)."/vendor/autoload.php";

    use App\{Autos, Marcas};
    $id= $_GET['id'];
    
    $datosAuto = (new Autos)->read($id);
    $datosMarca = (new Marcas)->readAll();
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

<body style="background-color: darkseagreen;">
    <h3 class="text-center mt-2">Informacion Auto</h3>
    <div class="container">
        <div class="card mx-auto mt-4" style="width: 38rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $datosAuto->modelo ?></h5>
                <h6 class="card-subtitle mb-2"><?php echo $datosAuto->tipo ?></h6>
                <h6 class="card-subtitle mb-2"><?php echo $datosAuto->matrícula ?></h6>
               
                    <?php 
                        foreach($datosMarca as $item){
                            if(($datosAuto->marca_id)==($item->id)){
                                echo "<h6 class='card-subtitle mb-2'>{$item->nombre}, {$item->pais}</h6>";
                            }
                        }
                    ?>
                <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
            </div>
        </div>
    </div>
</body>

</html>