<?php 
include('modelo/conexion.php');

/* Abrimos la conexión a la BD MySQL */
$conexion = conectar();

/* Verificamos si se ha recibido el id del curso a actualizar */
if (isset($_GET['id'])) {
    $curso_id = (int)$_GET['id'];
    /* Formamos la consulta SQL */
    $sqlactualizar = "SELECT * FROM curso WHERE curso_id = $curso_id";
    $resultadoactualizar = mysqli_query($conexion, $sqlactualizar);
    $curso = mysqli_fetch_array($resultadoactualizar);
}

/* Verificamos si el botón de actualizar ha sido presionado */
if (isset($_POST['botonactualizar'])) {
    /* Obtenemos la información del curso */
    $curso_id = $_POST['curso_id'];
    $nombre_curso = $_POST['nombre_curso'];
    $creditos = $_POST['creditos'];

    /* Formamos la consulta SQL */
    $sqlupdate = "UPDATE curso SET nombre_curso = '$nombre_curso', creditos = '$creditos' WHERE curso_id = $curso_id";
    /* Ejecutamos la instrucción SQL */
    $resultadoupdate = mysqli_query($conexion, $sqlupdate);

    if ($resultadoupdate) {
        header("Location: cursos.php");
        exit();
    }
}

/* Cerramos la conexión */
desconectar($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9cdb1aeb59.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
    <form class="col-4 p-3" method="post">
        <h3 class="text-center text-secondary">Actualizar Curso</h3>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Id del Curso</label>
            <input type="text" class="form-control" name="curso_id" value="<?php echo $curso['curso_id']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre del curso</label>
            <input type="text" class="form-control" name="nombre_curso" value="<?php echo $curso['nombre_curso']; ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Créditos del curso</label>
            <input type="text" class="form-control" name="creditos" value="<?php echo $curso['creditos']; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="botonactualizar" value="Ok">Actualizar</button>
    </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>