<?php 

include('modelo/conexion.php');

$curso_id = $_POST['curso_id'];
$alumno_id = $_POST['alumno_id'];

/* Abrimos la conexión a la BD MySQL */
$conexion = conectar();


/* Verificamos si se ha recibido el id del curso a eliminar */
if (isset($_GET['id'])) {
    $matricula_id = (int)$_GET['id'];
    /* Formamos la consulta SQL */
    $sqleliminar = "DELETE FROM matricula WHERE matricula_id = $matricula_id";

    /* Ejecutamos la instrucción SQL */
    $resultadoeliminar = mysqli_query($conexion, $sqleliminar);

    if ($resultadoeliminar) {
        header("Location: matriculas.php");
        exit();
    }
}

/* Verificamos si el botón de registro ha sido presionado */
if (isset($_POST['botonregistrar'])) {
    /* Obtenemos la información del alumno */
    $curso_id = $_POST['curso_id'];
    $alumno_id = $_POST['alumno_id'];

    /* Formamos la consulta SQL */
    $sqlingreso = "INSERT INTO matricula (curso_id, alumno_id) VALUES ('$curso_id', '$alumno_id')";

    /* Ejecutamos la instrucción SQL */
    $resultadoingreso = mysqli_query($conexion, $sqlingreso);

    if ($resultadoingreso) {
        header("Location: matriculas.php");
        exit();
    }
}


/* Definimos la consulta SQL */
$sql = 'SELECT matricula_id, nombre_curso, CONCAT(nombres, " ", ape_paterno, " ", ape_materno) AS nombre_alumno
        FROM matricula
        JOIN curso ON matricula.curso_id = curso.curso_id
        JOIN alumno ON matricula.alumno_id = alumno.alumno_id';

/* Ejecutamos el query en la conexión abierta */
$resultado = mysqli_query($conexion,$sql);

$sql_cursos = "SELECT curso_id, nombre_curso FROM curso";
$result_cursos = mysqli_query($conexion, $sql_cursos);

$sql_alumnos = "SELECT alumno_id, CONCAT(nombres, ' ', ape_paterno, ' ', ape_materno) AS nombre FROM alumno";
$resultado_alumnos = mysqli_query($conexion, $sql_alumnos);

$alumnos = array();
while ($row_alumnos = mysqli_fetch_assoc($resultado_alumnos)) {
    $alumnos[$row_alumnos['alumno_id']] = $row_alumnos['nombre'];
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
    <title>Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9cdb1aeb59.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-dark block-top bg-warning flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><h1>CRUD - Laboratorio 6</h1></a>
    </nav>
    <h1 class="text-center p-3">CRUD - Matrìculas</h1>
    
    <div class="container-fluid row">
    <form class="col-4 p-3" method="post">
        <h3 class="text-center text-secondary">Registro de matriculas</h3>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">matricula_id</label>
            <input type="text" class="form-control" name="matricula_id" placeholder="Solo usar para búsquedas">
        </div>
        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso</label>
            <select class="form-select" name="curso_id" id="curso_id">
                <option value="">Seleccione un curso</option>
                <?php while($row_cursos = mysqli_fetch_assoc($result_cursos)) { ?>
                <option value="<?php echo $row_cursos['curso_id']; ?>"><?php echo $row_cursos['nombre_curso']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="alumno_id" class="form-label">Alumno</label>
            <select class="form-select" name="alumno_id" id="alumno_id">
                <option value="">Seleccione un alumno</option>
                <?php foreach ($alumnos as $id => $nombre) { ?>
                    <option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
                <?php } ?>
            </select>
        </div>

        
        <button type="submit" class="btn btn-primary" name="botonregistrar" value="Ok">Registrar</button>
    </form>
    
    <div class="col-8 p-4">
        <table class="table table-striped">
            <thead class="bg-info">
                <tr>
                <th scope="col">matricula_id</th>
                <th scope="col">curso_id</th>
                <th scope="col">alumno_id</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody
            
            <?php
                while($curso = mysqli_fetch_array($resultado)){

                    $matricula_id = $curso['matricula_id'];
                    $nombre_curso = $curso['nombre_curso'];
                    $nombre_alumno = $curso['nombre_alumno'];
            
                    echo '<tr>';
                    echo '<td>'.$matricula_id.'</td>';
                    echo '<td>'.$nombre_curso.'</td>';
                    echo '<td>'.$nombre_alumno.'</td>';
                    echo '<td><a href="update.php?id='.$matricula_id.'" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
                    echo '<a href="matriculas.php?id='.$matricula_id.'" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a></td>';
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