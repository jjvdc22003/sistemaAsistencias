<?php 
    require "../Backend/Controllers/alumnosController.php";

    $id="";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    elseif (isset($_SESSION["matricula"])) {
        header('Location: indexA.php');
        exit();
    }
    
    if($_GET){
        $id = $_GET['id'];
        $alumnoController = new alumno;
        $buscar = $alumnoController->listOne($id);
        $alumno = $buscar['alumno'][0];
    }

    if($_POST){
        $id=(isset($_POST['id'])) ? $_POST['id']:"";
        $alumno = array(
            'matricula' => (isset($_POST['matricula'])) ? $_POST['matricula'] : "",
            'nombre' => (isset($_POST['nombre'])) ? $_POST['nombre'] : "",
            'sexo' => (isset($_POST['sexo'])) ? $_POST['sexo'] : "",
            'correo' => (isset($_POST['correo'])) ? $_POST['correo'] : "",
            'carrera' => (isset($_POST['carrera'])) ? $_POST['carrera'] : "",
            'grupo' => (isset($_POST['grupo'])) ? $_POST['grupo'] : ""
        );
        //Actualizar
        $alumnoController = new alumno;
        $actualizar = $alumnoController->update($id,$alumno);
        if($actualizar['status'] == 200){
            echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <p>Se ha actualizado correctamente a: <strong>"'.$alumno['nombre'].'"</strong></p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
            ';
        } else {
            echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <h1>ERROR</h1>
                        <p><strong>Error al actualizar: </strong>"'.$actualizar['error'].'"</p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
            ';
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar</title>
</head>
<body>
<h3>Actualizar usuario</h3>
    <form action="updateAlumno.php" method="post">
    Matricula:
        <input  value="<?php echo $alumno['matricula']; ?>" type="text" name="matricula" id="">
        <br/>
        <br/>
        Nombre:
        <input  value="<?php echo $alumno['nombre']; ?>" type="text" name="nombre" id="">
        <br/>
        <br/>
        Sexo:
        <select name="sexo" id="">
            <option value="H" <?php echo ($alumno['sexo']=='H')?"selected":""; ?> >H</option>
            <option value="M" <?php echo ($alumno['sexo']=='M')?"selected":""; ?> >M</option>
        </select>
        <br/>
        <br/>
        Correo:
        <input  value="<?php echo $alumno['correo']; ?>" type="text" name="correo" id="">
        <br/>
        <br/>
        Carrera:
        <select name="carrera" id="">
            <option value="Ingeniería en Computación" <?php echo ($alumno['carrera']=="Ingeniería en Computación")?"selected":""; ?> >Ingeniería en Computación</option>
            <option value="Ingeniería en Electrónica" <?php echo ($alumno['carrera']=="Ingeniería en Electrónica")?"selected":""; ?> >Ingenieria en Electrónica</option>
            <option value="Ingenieria en Diseño" <?php echo ($alumno['carrera']=="Ingenieria en Diseño")?"selected":""; ?> >Ingenieria en Diseño</option>
            <option value="Licenciatura en Ciencias Empresariales" <?php echo ($alumno['carrera']=="Licenciatura en Ciencias Empresariales")?"selected":""; ?> >Licenciatura en Ciencias Empresariales</option>
            <option value="Licenciatura en Matemáticas Aplicadas" <?php echo ($alumno['carrera']=="Licenciatura en Matemáticas Aplicadas")?"selected":""; ?> >Licenciatura en Matemáticas Aplicadas</option>
            <option value="Ingeniería en Alimentos" <?php echo ($alumno['carrera']=="Ingeniería en Aalimentos")?"selected":""; ?> >Ingeniería en Alimentos</option>
            <option value="Ingeniería Industrial" <?php echo ($alumno['carrera']=="Ingeniería Industrial")?"selected":""; ?> >Ingeniería Industrial</option>
            <option value="Ingeniería en Mecatrónica" <?php echo ($alumno['carrera']=="Ingeniería en Mecatrónica")?"selected":""; ?> >Ingeniería en Mecatrónica</option>
            <option value="Ingeniería en Física Aplicada" <?php echo ($alumno['carrera']=="Ingeniería en Física Aplicada")?"selected":""; ?> >Ingeniería en Física Aplicada</option>
            <option value="Ingeniería en Mecánica Automotriz" <?php echo ($alumno['carrera']=="Ingeniería en Mecánica Automotriz")?"selected":""; ?> >Ingeniería en Mecánica Automotriz</option>
            <option value="Ingeniería Civil" <?php echo ($alumno['carrera']=="Ingeniería Civil")?"selected":""; ?> >Ingenieria Civil</option>
            <option value="Ingeniería Química en Procesos Sostenibles" <?php echo ($alumno['carrera']=="Ingeniería Química en Procesos Sostenibles")?"selected":""; ?> >Ingeniería Química en Procesos Sostenibles</option>
        </select>
        <br/>
        <br/>
        Grupo:
        <input  value="<?php echo $alumno['grupo']; ?>" type="text" name="grupo" id="">
        <br/>
        <br/>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <a href="listAlumnos.php">Listar Alumnos</a>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>

<style>
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
    .close-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
    }
    .close-button:hover {
        background-color: #45a049;
    }
</style>

<!-- JavaScript para cerrar el modal y redirigir -->
<script>
    function closeModal() {
        window.location.href = 'listAlumnos.php';
    }
</script>
