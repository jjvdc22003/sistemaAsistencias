<?php
    require "../Backend/Controllers/alumnosController.php";

    session_start();
    //strtoupper($nombre)
     if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }

    if($_POST){
        $alumno = array(
            'matricula' => (isset($_POST['matricula'])) ? $_POST['matricula'] : "",
            'nombre' => (isset($_POST['nombre'])) ? $_POST['nombre'] : "",
            'sexo' => (isset($_POST['sexo'])) ? $_POST['sexo'] : "",
            'correo' => (isset($_POST['correo'])) ? $_POST['correo'] : "",
            'carrera' => (isset($_POST['carrera'])) ? $_POST['carrera'] : "",
            'grupo' => (isset($_POST['grupo'])) ? $_POST['grupo'] : ""
        );
        //Verificar si el alumno y correo ya existe
        $alumnoController = new alumno;
        $buscar = $alumnoController->listOneMatricula($alumno['matricula']);
        $buscarCorreo = $alumnoController->listOnePorCorreo($alumno['correo']);
        if($buscar['status'] == 200){
            if(!empty($buscar['alumno'])){
                echo '
                    <div id="errorModal" class="modal">
                        <div class="modal-content">
                            <h1>ERROR</h1>
                            <p>El alumno <strong>ya ha sido registrado</strong> anteriormente</p>
                            <span class="close-button" onclick="closeModal()">Cerrar</span>
                        </div>
                    </div>
                ';
            } elseif($buscarCorreo['status'] == 200) {
                if(!empty($buscarCorreo['cuenta'])){
                    echo '
                        <div id="errorModal" class="modal">
                            <div class="modal-content">
                                <h1>ERROR</h1>
                                <p>El correo <strong>ya ha sido registrado</strong> anteriormente</p>
                                <span class="close-button" onclick="closeModal()">Cerrar</span>
                            </div>
                        </div>
                    ';
                } else{
                    //Agregar
                    $agregar = $alumnoController->create($alumno);
                    if($agregar['status'] == 200){
                        echo '
                            <div id="successModal" class="modal">
                                <div class="modal-content">
                                    <p>Se ha agregado correctamente a: <strong>"'.$alumno['nombre'].'"</strong></p>
                                    <span class="close-button" onclick="closeModal()">Cerrar</span>
                                </div>
                            </div>
                        ';
                    } else {
                        echo '
                        <div id="errorModal" class="modal">
                                <div class="modal-content">
                                    <h1>ERROR</h1>
                                    <p><strong>Error al registrar: </strong>"'.$agregar['error'].'"</p>
                                    <span class="redirect-button" onclick="closeModal()">Cerrar</span>
                                </div>
                            </div>
                        ';
                    }
                }
            } else {
                echo '
                    <div id="successModal" class="modal">
                        <div class="modal-content">
                            <h1>ERROR</h1>
                            <p><strong>Error al buscar la existencia del correo: </strong>"'.$buscarCorreo['error'].'"</p>
                            <span class="close-button" onclick="closeModal()">Cerrar</span>
                        </div>
                    </div>
                ';
            }
        } else {
            echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <h1>ERROR</h1>
                        <p><strong>Error al buscar la existencia del alumno: </strong>"'.$buscar['error'].'"</p>
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
    <title>Agregar alumno</title>
</head>
<body>
    <h3>Agregar alumno</h3>
    <form action="createAlumno.php" method="post">
        Matrícula:
        <input type="text" name="matricula" id="" required>
        <br/>
        <br/>
        Nombre completo:
        <input type="text" name="nombre" id="" placeholder="Comenzado por apellidos" required>
        <br/>
        <br/>
        Sexo:
        <select name="sexo" id="" required>
            <option value="H">H</option>
            <option value="M">M</option>
        </select>
        <br/>
        <br/>
        Correo:
        <input type="email" name="correo" id="" required>
        <br/>
        <br/>
        Carrera:
        <select name="carrera" id="" required>
            <option value="" disabled selected>Selcciona una carrera</option>
            <option value="Ingeniería en Computación">Ingeniería en Computación</option>
            <option value="Ingeniería en Electrónica">Ingeniería en Electrónica</option>
            <option value="Ingeniería en Diseño">Ingeniería en Diseño</option>
            <option value="Licenciatura en Ciencias Empresariales">Licenciatura en Ciencias Empresariales</option>
            <option value="Licenciatura en Matemáticas Aplicadas">Licenciatura en Matemáticas Aplicadas</option>
            <option value="Ingeniería en Alimentos">Ingeniería en Alimentos</option>
            <option value="Ingeniería Industrial">Ingeniería Industrial</option>
            <option value="Ingeniería en Mecatrónica">Ingeniería en Mecatrónica</option>
            <option value="Ingeniería en Física Aplicada">Ingeniería en Física Aplicada</option>
            <option value="Ingeniería en Mecánica Automotriz">Ingeniería en Mecánica Automotriz</option>
            <option value="Ingeniería Civil">Ingeniería Civil</option>
            <option value="Ingeniería Química en Procesos Sostenibles">Ingeniería Química en Procesos Sostenibles</option>
        </select>
        <br/>
        <br/>
        Grupo:
        <input type="text" name="grupo" id="" required>
        <br/>
        <br/>
        <a href="listAlumnos.php">Cancelar</a>
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