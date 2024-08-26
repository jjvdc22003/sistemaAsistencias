<?php
    require "../../QR_back/Controllers/asistenciasController.php";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    elseif (isset($_SESSION["matricula"])) {
        header('Location: indexA.php');
        exit();
    }

    //Listar
    if($_GET){
        $matricula = (isset($_GET['matricula'])) ? $_GET['matricula'] : "";
        if($matricula != "") {
            //Obetner fecha
            date_default_timezone_set('Etc/GMT+6');
            $fecha = date("Y-m-d");
            $horaActual = date('H:i:s');
    
            //Comprobar si el alumno ya tiene asistencia
            $asistenciasController = new asistencia;
            $existencia = $asistenciasController->existe($matricula, $fecha);
            $comprobar = $existencia['asistencia'];
            if(!empty($comprobar)){
                if (isset($comprobar[0]['hora_salida'])) {
                 echo '
                     <div id="errorModal" class="modal">
                         <div class="modal-content">
                             <p>El alumno ya tiene asistencia el día de hoy.</p>
                             <span class="blue-button" onclick="reloadModal()">Registrar otra matrícula</span>
                             <span class="close-button" onclick="closeModal()">Volver al menú</span>
                         </div>
                     </div>
                 ';
                } else {
                     $asistenciaNueva = array(
                         'matricula_alumno' => $comprobar[0]['matricula_alumno'],
                         'fecha' => $comprobar[0]['fecha'],
                         'hora_entrada' => $comprobar[0]['hora_entrada'],
                         'hora_salida' => $horaActual
                     );
                     $actualizar = $asistenciasController->update($comprobar[0]['id'], $asistenciaNueva);
                     if($actualizar['status'] == 200) {
                         echo '
                             <div id="successModal" class="modal">
                                 <div class="modal-content">
                                     <p>Se ha registrado la salida del alumno.</p>
                                     <span class="blue-button" onclick="reloadModal()">Registrar otra matrícula</span>
                                     <span class="close-button" onclick="closeModal()">Volver al menú</span>
                                 </div>
                             </div>
                         ';
                     } else {
                         echo '
                             <div id="successModal" class="modal">
                                 <div class="modal-content">
                                     <h1>ERROR</h1>
                                     <p><strong>Error al registrar la salida: </strong>"'.$actualizar['error'].'"</p>
                                     <span class="close-button" onclick="closeModal()">Cerrar</span>
                                 </div>
                             </div>
                         ';
                     }
                }
             } else{
                 $asistenciaNueva = array(
                     'matricula_alumno' => $matricula,
                     'fecha' => $fecha,
                     'hora_entrada' => $horaActual
                 );
                 $agregar = $asistenciasController->createWithMatricula($asistenciaNueva);
                 if($agregar['status'] == 200) {
                     echo '
                         <div id="successModal" class="modal">
                             <div class="modal-content">
                                 <p>Se ha registrado la entrada del alumno.</p>
                                 <span class="blue-button" onclick="reloadModal()">Registrar otra matrícula</span>
                                 <span class="close-button" onclick="closeModal()">Volver al menú</span>
                             </div>
                         </div>
                     ';
                 } else {
                     echo '
                         <div id="successModal" class="modal">
                             <div class="modal-content">
                                 <h1>ERROR</h1>
                                 <p><strong>Error al registrar la entrada: </strong>"'.$agregar['error'].'"</p>
                                 <span class="close-button" onclick="closeModal()">Cerrar</span>
                             </div>
                         </div>
                     ';
                 }
             }
        } else {
            echo '
                <div id="matric" class="modal">
                    <div class="modal-content">
                        <p>La matrícula está <strong>VACÍA</strong>.</p>
                        <span class="blue-button" onclick="reloadModal()">Registrar otra matrícula</span>
                        <span class="close-button" onclick="closeModal()">Volver al menú de asistencias</span>
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
    <title>Registrar por matrícula</title>
</head>
<body>
    <h2>Registrar asistencia por matrícula</h2>
    <form action="registrarPorMatricula.php" method="get">
        Matrícula:
        <br>
        <input type="text" name="matricula" placeholder="Ingresa la matricula" size="30">
        <input type="submit" value="Registrar">
    </form>
    
     <br/>
     <br/>
     <a href="menuAsistencias.php" class="close-button">Regresar al menú de asistencias</a>
</body>
</html>

<script>
    function reloadModal() {
        window.location.href = 'registrarPorMatricula.php';
    }
    function closeModal() {
        window.location.href = 'menuAsistencias.php';
    }
</script>

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
    .centered-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 80px;
        height: 80px;
    }
    .blue-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #0087D1;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .blue-button:hover {
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
</style>