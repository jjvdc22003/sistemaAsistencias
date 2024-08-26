<?php
    require "../Backend/Controllers/alumnosController.php";
    require "../Backend/generateQR.php";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }

    if($_GET){
        if (empty(trim($_GET["query"]))) {
            echo '
                    <div id="errorModal" class="modal">
                        <div class="modal-content">
                            <p>Por favor, ingresa un término de búsqueda.</p>
                            <span class="close-button" onclick="closeModal()">Cerrar</span>
                        </div>
                    </div>
                ';
        } else {
            $matricula = $_GET["query"];
            $alumnoController = new alumno;
            $buscar = $alumnoController->listOneMatricula($matricula);
            if($buscar['status'] == 200){
                if(!empty($buscar['alumno'])){
                    $alumno = $buscar['alumno'][0];
                }
            } else {
                echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <h1>ERROR</h1>
                        <p><strong>Error al buscar: </strong>"'.$buscar['error'].'"</p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
                ';
            }
        }
    }
    if($_POST){
        $qr = new qr;
        $qr -> descargar($_POST['ruta']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda alumno</title>
</head>
<body>
    <?php if(!empty(trim($_GET["query"]))) {
        if(!empty($buscar['alumno'])){?>
    <h2>Alumno encontrado:</h2>
    <br/>
    <!-- Mostrar listado -->
    <table>
       <thead>
           <th>Matrícula</th>
           <th>Nombre</th>
           <th>Sexo</th>
           <th>Correo</th>
           <th>Carrera</th>
           <th>Grupo</th>
           <th>QR</th>
           <th></th>
           <th></th>
       </thead>
       <tbody>
           <tr>
               <td><?php echo $alumno['matricula']; ?></td>
               <td><?php echo $alumno['nombre']; ?></td>
               <td><?php echo $alumno['sexo']; ?></td>
               <td><?php echo $alumno['correo']; ?></td>
               <td><?php echo $alumno['carrera']; ?></td>
               <td><?php echo $alumno['grupo']; ?></td>
               <td>
               <form action="searchAlumno.php" method="post">
                            <img src="<?php echo "../assets/QR's/".$alumno['matricula'].".png" ?>" alt="QR del alumno" class="centered-image">
                            <input type="hidden" name="ruta" value="<?php echo "../../assets/QR's/".$alumno['matricula'].".png" ?>">
                            <input type="submit" value="Descargar">
                        </form>
               </td>
               <td class="centered">
                   <form action="updateAlumno.php" method="get"> 
                       <input type="hidden" name="id" value="<?php echo $alumno['id'] ?>">
                       <input type="submit" value="Actualizar">
                   </form>
               </td>
               <td class="centered">
                   <form action="deleteAlumno.php" method="get"> 
                       <input type="hidden" name="id" value="<?php echo $alumno['id'] ?>">
                       <input type="submit" value="Eliminar">
                   </form>
               </td>
           </tr>
       </tbody>
    </table>
    <br/>
    <a href="listAlumnos.php" class="close-button">Regresar</a>
    <?php } else{
        echo '
        <div id="errorModal" class="modal">
            <div class="modal-content">
                <p>La matrícula <strong>no se encuentra</strong> registrada.</p>
                <span class="close-button" onclick="closeModal()">Cerrar</span>
            </div>
        </div>
    ';
    } }?>
</body>
</html>

<script>
    function closeModal() {
        window.location.href = 'listAlumnos.php';
    }
</script>

<style>
    /* Estilos para la tabla */
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .centered {
        text-align: center; /* Centra el contenido horizontalmente */
        vertical-align: middle; /* Centra el contenido verticalmente */
    }
    form {
        display: inline-block; /* Asegura que el formulario no ocupe toda la celda */
    }
    .centered-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 80px;
        height: 80px;
    }
    .azul-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #0087D1;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .azul-button:hover {
      background-color: darkblue;
    }
    .close-button {
        background-color: #E62E00;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
    }
    .close-button:hover {
        background-color: #800000;
    }
    .modal {
        display: block; /* Mostrar el modal */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 40%;
        text-align: center;
    }
</style>