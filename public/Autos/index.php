<?php
    session_start();
    require dirname(__DIR__, 2)."/vendor/autoload.php";

    use App\Autos;


    $datos = (new Autos)->readAll();

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

<body style="background-color:darkseagreen;">
    <h3 class="text-center mt-2 mb-4">Gestionar Autos</h3>
    <div class="container">

        <div class="mb-2 d-flex flex-row-reverse">
            <a href="crear.php" class="btn btn-primary"><i class="fas fa-plus"></i> Añadir Auto</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Info</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Matricula</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($datos as $item) {
                        echo <<< TXT
                            <tr>
                                <th scope="row"><a href='info.php?id={$item->id}' class='btn btn-primary'><i class='fas fa-book'></i></th>
                                <td>{$item->modelo}</td>
                                <td>{$item->tipo}</td>
                                <td>{$item->matrícula}</td>
                                <td><a href='update.php?id={$item->id}' class='btn btn-warning'><i class='fas fa-pen-to-square'></i> Editar</td>
                                <td><a href='delete.php?id={$item->id}' class='btn btn-danger'><i class='fas fa-trash'></i> Borrar</td>
                            </tr>
                        TXT;
                    }
                ?>
            </tbody>
        </table>
    </div>
    
    <?php
        if(isset($_SESSION['info'])){
            ECHO <<< TXT
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '{$_SESSION['info']}',
                        showConfirmButton: false,
                        timer: 1500
                    })
                </script>

            TXT;
        }
        unset($_SESSION['info']);
    ?>
</body>

</html>