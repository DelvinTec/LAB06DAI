<?php 

include('modelo/conexion.php');



/* Abrimos la conexión a la BD MySQL */
$conexion = conectar();

/* Verificamos si se ha recibido el id del curso a eliminar */
if (isset($_GET['id'])) {
    $curso_id = (int)$_GET['id'];
    /* Formamos la consulta SQL */
    $sqleliminar = "DELETE FROM curso WHERE curso_id = $curso_id";

    /* Ejecutamos la instrucción SQL */
    $resultadoeliminar = mysqli_query($conexion, $sqleliminar);

    if ($resultadoeliminar) {
        header("Location: cursos.php");
        exit();
    }
}

/* Verificamos si el botón de registro ha sido presionado */
if (isset($_POST['botonregistrar'])) {
    /* Obtenemos la información del alumno */
    $nombre_curso = $_POST['nombre_curso'];
    $creditos = $_POST['creditos'];

    /* Formamos la consulta SQL */
    $sqlingreso = "INSERT INTO curso (nombre_curso, creditos) VALUES ('$nombre_curso', '$creditos')";

    /* Ejecutamos la instrucción SQL */
    $resultadoingreso = mysqli_query($conexion, $sqlingreso);

    if ($resultadoingreso) {
        header("Location: cursos.php");
        exit();
    }
}

/* Definimos la consulta SQL */
$sql = 'SELECT curso_id, nombre_curso, creditos FROM curso';

/* Ejecutamos el query en la conexión abierta */
$resultado = mysqli_query($conexion,$sql);

/* Cerramos la conexión */
desconectar($conexion);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9cdb1aeb59.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-dark block-top bg-warning flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><h1>CRUD - Laboratorio 6</h1></a>
    </nav>
    <h1 class="text-center p-3">CRUD - Cursos</h1>
    
    <div class="container-fluid row">
    <form class="col-4 p-3" method="post">
        <h3 class="text-center text-secondary">Registro de cursos</h3>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Id del Curso</label>
            <input type="text" class="form-control" name="idcurso" placeholder="Solo usar para búsquedas">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre del curso</label>
            <input type="text" class="form-control" name="nombre_curso">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Créditos del curso</label>
            <input type="text" class="form-control" name="creditos">
        </div>
        
        <button type="submit" class="btn btn-primary" name="botonregistrar" value="Ok">Registrar</button>
    </form>
    
    <div class="col-8 p-4">
        <table class="table table-striped">
            <thead class="bg-info">
                <tr>
                <th scope="col">curso_id</th>
                <th scope="col">nombre_curso</th>
                <th scope="col">creditos</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                while($curso = mysqli_fetch_array($resultado)){
                    
                    $curso_id = $curso['curso_id'];
                    $nombre_curso = $curso['nombre_curso'];
                    $creditos = $curso['creditos'];

                    echo '<tr>';
                    echo '<td>'.$curso_id.'</td>';
                    echo '<td>'.$nombre_curso.'</td>';
                    echo '<td>'.$creditos.'</td>';
                    echo '<td><a href="update.php?id='.$curso_id.'" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
                    echo '<a href="cursos.php?id='.$curso_id.'" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>